<?php

namespace App\Controllers;

use App\Models\OAuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\user;

class IndexController extends BaseController
{
    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function index(): string|RedirectResponse
    {
        $user = user();
        $client = client();

        $vouchers = connect($client)->stat_voucher();
        if ($vouchers === false)
            return view('IndexView', ['vouchers' => [], 'error' => lang('vouchers.error.unknown')]);

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

        return view('IndexView', ['vouchers' => $vouchers, 'clientsConnected' => $clientsConnected]);
    }

    /**
     * @throws OAuthException
     * @throws UniFiException
     */
    public function createVoucher(): string|RedirectResponse
    {
        $user = user();
        $quota = $this->request->getPost('quota');
        $duration = $this->request->getPost('duration');

        $client = client();
        $result = connect($client)->create_voucher($duration, 1, $quota, $user->username);
        if (!$result)
            return redirect('/')->with('error', lang('vouchers.error.unknown'));

        foreach ($result as $item) {
            $createTime = $item->create_time;
            $voucher = $client->stat_voucher($createTime)[0];
            return redirect('/')->with('voucher', $voucher);
        }

        return redirect('/')->with('error', lang('vouchers.error.unknown'));
    }
}
