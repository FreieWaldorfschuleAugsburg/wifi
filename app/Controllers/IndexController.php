<?php

namespace App\Controllers;

use function App\Helpers\isLoggedIn;

class IndexController extends BaseController
{
    public function index()
    {
        helper('user');

        if (isLoggedIn()) {
            return $this->render('IndexView');
        }

        return redirect('login');
    }

    public function createVoucher()
    {
        helper('unifi');

        $usages = $this->request->getPost('voucherUsages');
        $expireAt = strtotime($this->request->getPost('voucherExpire'));
        $duration = (int)(($expireAt - time()) / 60);

        $client = client();
        $result = $client->create_voucher($duration, 1, $usages);

        foreach ($result as $item) {
            $createTime = $item->create_time;
            $voucher = $client->stat_voucher($createTime)[0];

        }
    }
}
