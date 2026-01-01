<?php

namespace App\Controllers;

use App\Models\OAuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\login;
use function App\Helpers\user;

class VoucherController extends BaseController
{
    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function index(): string|RedirectResponse
    {
        $user = user();

        if (!isVoucherEnabled($user->currentSite)) {
            return redirect('/')->with('error', lang('menu.error.functionDisabled'));
        }

        $client = client();
        connect($client);

        $vouchers = $client->stat_voucher();
        if ($vouchers === false) {
            return view('VoucherView', ['vouchers' => [], 'error' => lang('vouchers.error.unknown')]);
        }

        return view('VoucherView', ['vouchers' => $vouchers]);
    }

    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function create(): string|RedirectResponse
    {
        $user = user();

        $quota = $this->request->getPost('quota');
        $duration = $this->request->getPost('duration');
        $unit = $this->request->getPost('unit');

        $client = client();
        connect($client);

        $result = $client->create_voucher($duration * $unit, 1, $quota, $user->username);
        if ($result === false) {
            return redirect('admin/vouchers')->with('error', lang('vouchers.error.unknown'));
        }

        foreach ($result as $item) {
            $createTime = $item->create_time;
            $voucher = $client->stat_voucher($createTime)[0];

            return redirect('admin/vouchers')->with('voucher', $voucher);
        }

        return redirect('admin/vouchers')->with('error', lang('vouchers.error.unknown'));
    }

    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function show(): string|RedirectResponse
    {
        $user = user();
        $id = $this->request->getGet('id');
        $returnUrl = $this->request->getGet('returnUrl');

        $client = client();
        connect($client);

        $vouchers = $client->stat_voucher();
        if ($vouchers === false) {
            return redirect($returnUrl)->with('error', lang('vouchers.error.unknown'));
        }

        foreach ($vouchers as $voucher) {
            if ($voucher->_id !== $id) continue;

            if (!$user->admin && (!isset($voucher->note) || ($voucher->note !== $user->username))) {
                return redirect($returnUrl)->with('error', lang('vouchers.error.disallowed'));
            }

            return redirect($returnUrl)->with('voucher', $voucher);
        }

        return redirect($returnUrl);
    }

    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function delete(): string|RedirectResponse
    {
        $user = user();
        if (is_null($user)) {
            return login();
        }

        $id = $this->request->getGet('id');
        $returnUrl = $this->request->getGet('returnUrl');

        $client = client();
        connect($client);

        $vouchers = $client->stat_voucher();
        if ($vouchers === false) {
            return redirect($returnUrl)->with('error', lang('vouchers.error.unknown'));
        }

        if (!$user->admin) {
            foreach ($vouchers as $voucher) {
                if ($voucher->_id === $id && (!isset($voucher->note) || ($voucher->note !== $user->username))) {
                    return redirect($returnUrl)->with('error', lang('vouchers.error.disallowed'));
                }
            }
        }

        $result = $client->revoke_voucher($id);
        if ($result === false) {
            return redirect($returnUrl)->with('error', lang('vouchers.error.unknown'));
        }

        return redirect($returnUrl);
    }
}
