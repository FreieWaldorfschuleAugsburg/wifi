<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="alert alert-warning mb-3">
            <h5><?= lang('index.disclaimer.title') ?></h5>
            <?= lang('index.disclaimer.text') ?>
        </div>

        <?= !empty(session('voucher')) ? '<div class="alert alert-success mb-3 text-center"> <i class="fas fa-check-circle fa-5x"></i><br/><h1>' . lang('index.voucher.created') . '</h1><h4>' . session('voucher')->code . '</h4></div>' : '' ?>
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.voucher.title') ?>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/createVoucher') ?>" method="POST">
                    <div class="mb-3">
                        <label for="quota" class="form-label"><?= lang('index.voucher.quota.label') ?> </label>
                        <div class="progress" style="height: 30px; font-size: 15px">
                            <div id="quotaBar" class="progress-bar" role="progressbar"></div>
                        </div>
                        <input type="range" min="1" max="<?= getenv('voucher.maxQuota') ?>" step="1" value="<?= getenv('voucher.defaultQuota') ?>" class="form-range"
                               name="quota"
                               id="quota"
                               alt="<?= lang('index.voucher.quota.unit') ?>"
                               onchange="update(this)"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label"><?= lang('index.voucher.duration.label') ?> </label>
                        <div class="progress" style="height: 30px; font-size: 15px">
                            <div id="durationBar" class="progress-bar" role="progressbar"></div>
                        </div>
                        <input type="range" min="1" max="<?= getenv('voucher.maxDuration') ?>" step="1" value="<?= getenv('voucher.defaultDuration') ?>" class="form-range"
                               name="duration"
                               id="duration"
                               alt="<?= lang('index.voucher.duration.unit') ?>"
                               onchange="update(this)"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('index.voucher.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.vouchers.title') ?>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('vouchers.list.code') ?></th>
                        <th scope="col"><?= lang('vouchers.list.quota') ?></th>
                        <th scope="col"><?= lang('vouchers.list.duration') ?></th>
                        <th scope="col"><?= lang('vouchers.list.createTime') ?></th>
                        <th scope="col"><?= lang('vouchers.list.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($vouchers as $voucher) {
                        echo '<tr>';
                        echo '<td onclick="toggleBlur(this)" style="color: transparent; text-shadow: 0 0 10px rgba(0,0,0,0.5); cursor: pointer">' . $voucher->code . '</td>';
                        echo '<td>' . $voucher->quota . '</td>';
                        echo '<td>' . $voucher->duration . 'm</td>';
                        echo '<td>' . date("d.m.Y H:i", $voucher->create_time) . '</td>';
                        echo '<td><a class="btn btn-danger btn-sm" href="javascript:confirmRedirect(\'' . base_url('admin/vouchers/delete') . '?id=' . $voucher->_id . '&returnUrl=/\')"><i class="fas fa-trash"></i> ' . lang('vouchers.list.delete') . '</a></td>';
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
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll('input[type=range]');
        for (let i = 0; i < elements.length; i++) {
            update(elements[i])
        }
    });

    function update(element) {
        const bar = document.getElementById(element.id + 'Bar');
        bar.textContent = element.value + ' ' + element.alt;
        bar.style.width = ((element.value / element.max) * 100) + '%';
    }

    function confirmRedirect(url) {
        if (confirm('<?= lang('vouchers.confirm') ?>')) {
            window.location.href = url;
        }
    }

    function toggleBlur(element) {
        element.style.color = (element.style.color === 'transparent' ? 'black' : 'transparent');
    }
</script>