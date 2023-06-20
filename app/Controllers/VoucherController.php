<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\isAdmin;
use function App\Helpers\isLoggedIn;
use function App\Helpers\user;

class VoucherController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        try {
            $user = user();

            if (is_null($user)) {
                return redirect('login');
            }

            if (!$user->admin) {
                return redirect('/');
            }

            if (!isVoucherEnabled($user->currentSite)) {
                return redirect('/')->with('error', lang('menu.error.functionDisabled'));
            }

            $client = client();
            try {
                connect($client);

                $vouchers = $client->stat_voucher();
                if ($vouchers === false) {
                    return $this->render('VoucherView', ['vouchers' => [], 'error' => lang('vouchers.error.unknown')]);
                }

                return $this->render('VoucherView', ['vouchers' => $vouchers]);
            } catch (UniFiException) {
                return handleUniFiException($client);
            } finally {
                $client->logout();
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function create(): RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return redirect('login');
            }

            if (!$user->admin) {
                return redirect('/');
            }

            $quota = $this->request->getPost('quota');
            $duration = $this->request->getPost('duration');
            $unit = $this->request->getPost('unit');

            $client = client();
            try {
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
            } catch (UniFiException) {
                return handleUniFiException($client);
            } finally {
                $client->logout();
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function delete(): RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return redirect('login');
            }

            $id = $this->request->getGet('id');
            $returnUrl = $this->request->getGet('returnUrl');

            $client = client();
            try {
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
            } catch (UniFiException) {
                return handleUniFiException($client);
            } finally {
                $client->logout();
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
