<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\handleAuthException;
use function App\Helpers\login;
use function App\Helpers\user;

class IndexController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        try {
            $user = user();

            if (!is_null($user)) {

                $client = client();
                try {
                    $vouchers = connect($client)->stat_voucher();
                    if ($vouchers === false)
                        return $this->render('IndexView', ['vouchers' => [], 'error' => lang('vouchers.error.unknown')]);

                    foreach ($vouchers as $key => $value) {
                        if (isset($value->note) && $value->note !== $user->username) {
                            unset($vouchers[$key]);
                        }
                    }

                    $connectedClients = $client->list_clients();
                    $clientsConnected = 0;
                    foreach ($connectedClients as $connectedClient) {
                        if (property_exists($connectedClient, 'essid') && $connectedClient->essid == getSiteProperty($user->currentSite, 'guestSSID')) {
                            $clientsConnected++;
                        }
                    }

                    return $this->render('IndexView', ['vouchers' => $vouchers, 'clientsConnected' => $clientsConnected]);
                } catch (UniFiException $e) {
                    return handleUniFiException($client, $e);
                }
            }
            return login();
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }

    public function createVoucher(): string|RedirectResponse
    {
        try {
            $user = user();

            if (is_null($user)) {
                return login();
            }

            $quota = $this->request->getPost('quota');
            $duration = $this->request->getPost('duration');

            $client = client();
            try {
                $result = connect($client)->create_voucher($duration, 1, $quota, $user->username);
                if (!$result)
                    return redirect('/')->with('error', lang('vouchers.error.unknown'));

                foreach ($result as $item) {
                    $createTime = $item->create_time;
                    $voucher = $client->stat_voucher($createTime)[0];
                    return redirect('/')->with('voucher', $voucher);
                }

                return redirect('/')->with('error', lang('vouchers.error.unknown'));
            } catch (UniFiException $e) {
                return handleUniFiException($client, $e);
            }
        } catch (AuthException $e) {
            return handleAuthException($this, $e);
        }
    }
}
