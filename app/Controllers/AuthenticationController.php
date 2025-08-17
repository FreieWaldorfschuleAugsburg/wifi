<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\login;
use function App\Helpers\logout;
use function App\Helpers\user;

class AuthenticationController extends BaseController
{

    public function changeSite(): string|RedirectResponse
    {
        $site = $this->request->getGet('site');

        try {
            $user = user();
            if (!in_array($site, $user->sitesAvailable)) {
                return redirect('/')->with('error', lang('menu.error.siteNotPermitted'));
            }

            $user->currentSite = $site;
            session()->set('USER', $user);
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }

        return redirect('/');
    }

    public function logout(): string|RedirectResponse
    {
        try {
            return logout();
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }
}