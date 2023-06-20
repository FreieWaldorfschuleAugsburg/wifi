<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\isLoggedIn;
use function App\Helpers\login;
use function App\Helpers\logout;
use function App\Helpers\user;

class AuthenticationController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function login(): string|RedirectResponse
    {
        try {
            if (isLoggedIn()) {
                return redirect('/');
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }

        // This will never throw an exception since we're not rendering the navbar
        return $this->render('LoginView', NULL, false);
    }

    public function handleLogin(): string|RedirectResponse
    {
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        try {
            login($username, $password);
        } catch (AuthException $e) {
            return handleAuthException($e);
        }

        return redirect('/');
    }

    public function changeSite(): RedirectResponse
    {
        $site = $this->request->getGet('site');

        try {
            $user = user();
            if (!in_array($site, $user->sitesAvailable)) {
                return redirect('/')->with('error', lang('menu.error.siteNotPermitted'));
            }

            session()->set('SITE', $site);
        } catch (AuthException $e) {
            return handleAuthException($e);
        }

        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        logout();
        return redirect('login');
    }
}