<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\isLoggedIn;
use function App\Helpers\user;

class AuthenticationController extends BaseController
{
    public function login()
    {
        helper('user');

        if (isLoggedIn()) {
            return redirect('dashboard');
        }

        return $this->render('LoginView', NULL, false);
    }

    public function logout(): RedirectResponse
    {
        helper('user');

        if (!isLoggedIn()) {
            return redirect('login');
        }

        session()->remove('USER_ID');

        return redirect('login');
    }

    public function handleLogin(): RedirectResponse
    {
        $db = db_connect('default');

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        $userRow = $db->table('wifi_users')->where('username', $username)->select()->get()->getRow();
        if (!isset($userRow)) {
            return $this->redirectWithError($username, 'loginView.invalidUsername');
        }

        if (!password_verify($password, $userRow->password)) {
            return $this->redirectWithError($username, 'loginView.invalidPassword');
        }

        session()->set('USER_ID', $userRow->id);

        return redirect('dashboard');
    }

    public function changePassword()
    {
        helper('user');

        if (!isLoggedIn()) {
            return redirect('login');
        }

        return $this->render('PasswordChangeView');
    }

    public function handlePasswordChange(): RedirectResponse
    {
        helper('user');

        $user = user();
        if (is_null($user)) {
            return redirect('login');
        }

        $password = trim($this->request->getPost('password'));
        $repeatedPassword = trim($this->request->getPost('repeatedPassword'));

        if ($password != $repeatedPassword) {
            return redirect('changePassword')->with('error', 'passwordChangeView.notMatching');
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $db = db_connect('default');
        $db->table('wifi_users')->where('id', $user->id)->set(['password' => $hashedPassword])->update();

        return redirect('logout');
    }

    public function redirectWithError($username, $error): RedirectResponse
    {
        return redirect('login')->with('username', $username)->with('error', $error);
    }
}