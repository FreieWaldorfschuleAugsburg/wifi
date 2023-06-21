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
        try {
            $user = user();

            if (is_null($user)) {
                return redirect('login');
            }

            if (!$user->admin) {
                return redirect('/');
            }

            if (!isStudentEnabled($user->currentSite)) {
                return redirect('/')->with('error', lang('menu.error.functionDisabled'));
            }

            $networkClient = client();
            try {
                connect($networkClient);

                $students = $networkClient->list_radius_accounts();
                if ($students === false) {
                    return $this->render('StudentView', ['students' => [], 'error' => lang('students.error.unknown')]);
                }

                $allClients = $networkClient->stat_allusers();
                $onlineClients = $networkClient->list_clients();

                if (!$allClients || !$onlineClients) {
                    throw new UniFiException('error fetching clients');
                }

                foreach ($students as $key => $value) {
                    if (isset($value->tunnel_type) || isset($value->tunnel_medium_type)) {
                        unset($students[$key]);
                        continue;
                    }

                    $value->devices = [];
                    $value->clients = 0;
                    foreach ($allClients as $client) {
                        if (property_exists($client, 'name') && $client->name === getenv('students.clientPrefix') . $value->name) {
                            $value->devices[$client->mac] = false;
                            $value->clients++;
                        }
                    }

                    $value->connectedClients = 0;
                    if ($value->devices) {
                        // Count the amount of clients using this identity
                        foreach ($onlineClients as $client) {
                            if (property_exists($client, '1x_identity') && $client->{'1x_identity'} === $value->name) {
                                $value->devices[$client->mac] = true;
                                $value->connectedClients++;
                            }
                        }
                    }
                }

                // Sort DESC by amount of overall clients
                usort($students, fn($a, $b) => $b->clients - $a->clients);

                // Sort DESC by amount of connected clients
                usort($students, fn($a, $b) => $b->connectedClients - $a->connectedClients);

                return $this->render('StudentView', ['students' => $students]);
            } catch (UniFiException $e) {
                return handleUniFiException($networkClient, $e);
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function create(): string|RedirectResponse
    {
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

            $client = client();
            try {
                connect($client);

                $students = $client->list_radius_accounts();
                if (!$students) {
                    throw new UniFiException('error fetching radius accounts');
                }

                foreach ($students as $student) {
                    if ($student->name === $name) {
                        return redirect('admin/students')->with('error', lang('students.error.alreadyExistent'));
                    }
                }

                $result = $client->create_radius_account($name, $password);
                if ($result === false) {
                    return redirect('admin/students')->with('error', lang('students.error.unknown'));
                }

                if ($print) {
                    return $this->render('StudentPrintView', ['student' => $result[0]], false);
                }

                return redirect('admin/students')->with('student', $result[0]);
            } catch (UniFiException $e) {
                return handleUniFiException($client, $e);
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function delete(): string|RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return redirect('login');
            }

            if (!$user->admin) {
                return redirect('/');
            }

            $id = $this->request->getGet('id');

            $client = client();
            try {
                connect($client);

                $students = $client->list_radius_accounts();
                if (!$students) {
                    throw new UniFiException('error fetching radius accounts');
                }

                $result = $client->delete_radius_account($id);
                if (!$result) {
                    return redirect('admin/students')->with('error', lang('students.error.unknown'));
                }

                $candidate = null;
                foreach ($students as $student) {
                    if ($student->_id === $id) {
                        $candidate = $student;
                        break;
                    }
                }

                if ($candidate == null) {
                    return redirect('admin/students')->with('error', lang('students.error.deleted'));
                }

                // Kick client from network by blocking and un-blocking client
                $clients = $client->list_clients();
                if (!$clients) {
                    throw new UniFiException('error fetching clients');
                }

                $successfulDisconnectedClients = 0;
                $unsuccessfulDisconnectedClients = 0;
                foreach ($clients as $client) {
                    if (property_exists($client, '1x_identity') && $client->{'1x_identity'} === $candidate->name) {
                        if (client()->block_sta($client->mac) && client()->unblock_sta($client->mac)) {
                            $successfulDisconnectedClients++;
                        } else {
                            $unsuccessfulDisconnectedClients++;
                        }
                    }
                }

                if ($unsuccessfulDisconnectedClients > 0) {
                    return redirect('admin/students')->with('info', sprintf(lang('students.error.disconnected'),
                        $successfulDisconnectedClients, $unsuccessfulDisconnectedClients));
                } else {
                    return redirect('admin/students')->with('info', sprintf(lang('students.info.disconnected'), $successfulDisconnectedClients));
                }
            } catch (UniFiException $e) {
                return handleUniFiException($client, $e);
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function print(): string|RedirectResponse
    {
        try {
            $user = user();
            if (is_null($user)) {
                return redirect('login');
            }

            if (!$user->admin) {
                return redirect('/');
            }

            $id = $this->request->getGet('id');

            $client = client();
            try {
                connect($client);

                $students = $client->list_radius_accounts();
                if (!$students) {
                    throw new UniFiException('error fetching radius accounts');
                }

                foreach ($students as $student) {
                    if ($student->_id === $id) {
                        return $this->render('StudentPrintView', ['student' => $student], false, false);
                    }
                }

                return redirect('admin/students')->with('error', lang('students.error.deleted'));
            } catch (UniFiException $e) {
                return handleUniFiException($client, $e);
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }

    public function cron(): void
    {
        if (getenv('students.cronIP') !== $_SERVER['REMOTE_ADDR']) {
            echo 'No remote access allowed! (' . $_SERVER['REMOTE_ADDR'] . ')';
            $this->response->setStatusCode(400);
            return;
        }

        try {
            $networkClient = client();
            try {
                connect($networkClient);

                $students = $networkClient->list_radius_accounts();
                $clients = $networkClient->list_clients();

                $start = floor(microtime(true) * 1000);

                foreach ($clients as $client) {
                    if (property_exists($client, '1x_identity')) {
                        $identity = $client->{'1x_identity'};

                        $found = false;
                        foreach ($students as $student) {
                            if ($student->name === $identity) {
                                $found = true;

                                $clientName = getenv('students.clientPrefix') . $identity;
                                if (!property_exists($client, 'name') || $client->name !== $clientName) {
                                    $networkClient->edit_client_name($client->_id, $clientName);
                                    echo 'Renamed "' . $client->mac . '" to "' . $clientName . '"<br>';
                                }
                            }
                        }

                        if (!$found) {
                            $networkClient->block_sta($client->mac);
                            $networkClient->unblock_sta($client->mac);

                            echo 'Kicked "' . $client->mac . '" due to invalid identity "' . $identity . '"<br>';
                        }
                    }
                }

                echo 'Done! (' . floor(microtime(true) * 1000) - $start . 'ms)<br>';
            } catch (UniFiException) {
                echo $networkClient->get_last_error_message();
            }
        } catch (AuthException $e) {
            echo $e->getMessage();
        }
    }
}
