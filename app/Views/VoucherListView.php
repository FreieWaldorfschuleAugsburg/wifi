<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('vouchers.title') ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('vouchers.code') ?></th>#
                        <th scope="col"><?= lang('vouchers.quota') ?></th>
                        <th scope="col"><?= lang('vouchers.duration') ?></th>
                        <th scope="col"><?= lang('vouchers.createTime') ?></th>
                        <th scope="col"><?= lang('vouchers.creator') ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    echo '<pre>';
                    print_r($vouchers);
                    echo '</pre>';
                    foreach ($vouchers as $voucher) {
                        echo '<tr>';
                        echo '<td>' . $voucher->code . '</td>';
                        echo '<td>' . $voucher->quota . '</td>';
                        echo '<td>' . $voucher->duration . 'm</td>';
                        echo '<td>' . date("d.m.Y H:m", $voucher->create_time) . '</td>';
                        echo '<td>' . $voucher->note . '</td>';
                        echo '<td><button class="btn btn-danger btn-sm" onclick="confirmRedirect(\'' . base_url('admin/vouchers/delete') . '?id=' . $voucher->_id . '\')"><i class="fas fa-trash"></i> Löschen</button>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRedirect(url) {
        if (confirm('<?= lang('vouchers.confirm') ?>')) {
            window.location.href = url;
        }
    }
</script>