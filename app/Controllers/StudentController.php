<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\user;

class StudentController extends BaseController
{
    /**
     * @throws OAuthException
     */
    public function index(): string|RedirectResponse
    {
        $user = user();
        if (!isStudentEnabled($user->currentSite)) {
            return redirect('/')->with('error', lang('menu.error.functionDisabled'));
        }

        $allStudents = getAllStudents();
        $activeStudents = getActiveStudents();

        return view("StudentsView", ["activeStudents" => $activeStudents, "allStudents" => $allStudents]);
    }

    public function create(): RedirectResponse
    {
        $username = $this->request->getPost('username');
        addStudent($username);

        return redirect('admin/students');
    }

    public function delete(): string|RedirectResponse
    {
        $student = $this->request->getGet('username');
        removeStudent($student);

        return redirect('admin/students');
    }
}
