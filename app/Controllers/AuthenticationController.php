<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;
use function App\Helpers\user;

class AuthenticationController extends BaseController
{

    /**
     * @throws OAuthException
     */
    public function changeSite(): string|RedirectResponse
    {
        $site = $this->request->getGet('site');

        $user = user();
        if (!in_array($site, $user->sitesAvailable)) {
            return redirect('/')->with('error', lang('menu.error.siteNotPermitted'));
        }

        $user->currentSite = $site;
        session()->set('USER', $user);

        return redirect('/');
    }

    /**
     * @throws OAuthException
     */
    public function logout(): string|RedirectResponse
    {
        return logout();
    }
}