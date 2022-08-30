<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\user;

class IndexController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        helper('auth');

        try {
            $user = user();

            if (!is_null($user)) {
                helper('unifi');
                try {
                    $vouchers = client()->stat_voucher();

                    foreach ($vouchers as $key => $value) {
                        if (isset($value->note) && $value->note !== $user->username) {
                            unset($vouchers[$key]);
                        }
                    }

                    return $this->render('IndexView', ['vouchers' => $vouchers]);
                } catch (UniFiException $ue) {
                    return redirect('/')->with('error', $ue->getMessage());
                }
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }

        return redirect('login');
    }

    public function createVoucher(): RedirectResponse
    {
        helper('auth');

        try {
            $user = user();

            if (is_null($user)) {
                return redirect('login');
            }

            $quota = $this->request->getPost('quota');
            $duration = $this->request->getPost('duration');

            helper('unifi');
            try {
                $result = client()->create_voucher($duration, 1, $quota, $user->username);

                foreach ($result as $item) {
                    $createTime = $item->create_time;
                    $voucher = client()->stat_voucher($createTime)[0];

                    return redirect('/')->with('voucher', $voucher);
                }

                return redirect('/')->with('error', 'Unknown error.');
            } catch (UniFiException $ue) {
                return redirect('/')->with('error', $ue->getMessage());
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
