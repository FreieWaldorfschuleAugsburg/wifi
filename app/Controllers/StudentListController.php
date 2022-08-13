<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\isAdmin;
use function App\Helpers\isLoggedIn;

class StudentListController extends BaseController
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
            $students = client()->list_radius_accounts();
            return $this->render('StudentListView', ['students' => $students]);
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
