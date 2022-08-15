<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\user;

class StudentController extends BaseController
{
    public function index(): string|RedirectResponse
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

            helper('unifi');
            try {
                $students = client()->list_radius_accounts();
                if ($students === false) {
                    return $this->render('StudentView', ['students' => [], 'error' => lang('students.error.unknown')]);
                }

                foreach ($students as $key => $value) {
                    if (isset($value->tunnel_type) || isset($value->tunnel_medium_type)) {
                        unset($students[$key]);
                    }
                }
                return $this->render('StudentView', ['students' => $students]);
            } catch (UniFiException $ue) {
                return $this->render('StudentView', ['students' => [], 'error' => $ue->getMessage()]);
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

            $name = str_replace(' ', '', ucwords($this->request->getPost('name'), ' '));
            $password = bin2hex(openssl_random_pseudo_bytes(getenv('students.passwordLength') / 2));
            $print = $this->request->getPost('print');

            helper('unifi');
            try {
                $result = client()->create_radius_account($name, $password);
                if ($result === false) {
                    return redirect('admin/students')->with('error', lang('students.error.unknown'));
                }

                return redirect('admin/students')->with('student', $result[0]);
            } catch (UniFiException $ue) {
                return redirect('admin/students')->with('error', $ue->getMessage());
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function delete(): RedirectResponse
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

            $id = $this->request->getGet('id');

            helper('unifi');
            try {
                $result = client()->delete_radius_account($id);
                if ($result === false) {
                    return redirect('admin/students')->with('error', lang('students.error.unknown'));
                }

                return redirect('admin/students');
            } catch (UniFiException $ue) {
                return redirect('admin/students')->with('error', $ue->getMessage());
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function print(): string|RedirectResponse
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

            $id = $this->request->getGet('id');

            helper('unifi');
            try {
                $students = client()->list_radius_accounts();
                if ($students === false) {
                    return $this->render('StudentView', ['students' => [], 'error' => lang('students.error.unknown')]);
                }

                foreach ($students as $student) {
                    if ($student->_id === $id) {
                        return $this->render('StudentPrintView', ['student' => $student], false);
                    }
                }

                return redirect('admin/students')->with('error', lang('students.error.deleted'));
            } catch (UniFiException $ue) {
                return redirect('admin/students')->with('error', $ue->getMessage());
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
