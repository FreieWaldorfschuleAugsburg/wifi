<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\isAdmin;
use function App\Helpers\isLoggedIn;

class VoucherListController extends BaseController
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
            $vouchers = client()->stat_voucher();
            return $this->render('VoucherListView', ['vouchers' => $vouchers]);
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
