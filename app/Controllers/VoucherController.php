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
        helper('auth');

        try {
            if (!isLoggedIn()) {
                return redirect('login');
            }

            if (!isAdmin()) {
                return redirect('/');
            }

            helper('unifi');
            try {
                $vouchers = client()->stat_voucher();
                return $this->render('VoucherView', ['vouchers' => $vouchers]);
            } catch (UniFiException $ue) {
                return $this->render('VoucherView', ['vouchers' => [], 'error' => $ue->getMessage()]);
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function create(): RedirectResponse
    {
        helper('auth');

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

            helper('unifi');
            try {
                $result = client()->create_voucher($duration * $unit, 1, $quota, $user->username);

                foreach ($result as $item) {
                    $createTime = $item->create_time;
                    $voucher = client()->stat_voucher($createTime)[0];

                    return redirect('admin/vouchers')->with('voucher', $voucher);
                }
            } catch (UniFiException $ignored) {
            }

            // TODO better error handling?
            return redirect('admin/vouchers');
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function delete(): RedirectResponse
    {
        helper('auth');
        try {
            if (!isLoggedIn()) {
                return redirect('login');
            }

            if (!isAdmin()) {
                return redirect('/');
            }

            $id = $this->request->getGet('id');
            helper('unifi');
            try {
                client()->revoke_voucher($id);
            } catch (UniFiException $ignored) {
            }

            return redirect('admin/vouchers');
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
