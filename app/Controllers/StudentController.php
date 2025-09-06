<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\isAdmin;
use function App\Helpers\isLoggedIn;
use function App\Helpers\login;
use function App\Helpers\user;

class StudentController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        try {
            $user = user();

            if (is_null($user)) {
                return login();
            }

            if (!$user->admin) {
                return redirect('/');
            }

            if (!isStudentEnabled($user->currentSite)) {
                return redirect('/')->with('error', lang('menu.error.functionDisabled'));
            }

            $allStudents = getAllStudents();
            $activeStudents = getActiveStudents();

            return $this->render("StudentsView", ["activeStudents" => $activeStudents, "allStudents" => $allStudents]);
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }

    public function create(): string|RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return login();
            }

            if (!$user->admin) {
                return redirect('/');
            }

            $username = $this->request->getPost('username');
            addStudent($username);

            return redirect('admin/students');
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }

    public function delete(): string|RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return login();
            }

            if (!$user->admin) {
                return redirect('/');
            }

            $student = $this->request->getGet('username');
            removeStudent($student);

            return redirect('admin/students');
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }
}
