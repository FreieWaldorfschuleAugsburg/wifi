<?php

namespace App\Filters;

use App\Models\OAuthException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use function App\Helpers\isPermitted;
use function App\Helpers\login;
use function App\Helpers\user;

class LoginFilter implements FilterInterface
{
    /**
     * @throws OAuthException
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('oauth');
        helper('site');

        $user = user();
        if (is_null($user)) {
            return login();
        }

        if (!isPermitted($user)) {
            throw new OAuthException('noPermissions');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}