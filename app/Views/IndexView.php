<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <?= !empty(session('voucher')) ? '<div class="alert alert-success mb-3 text-center"><h1><i class="fas fa-check-circle"></i> ' . lang('index.voucher.created') . '</h1><span style="font-size: 100px"><b>' . substr(chunk_split(session('voucher')->code, 5, '-'), 0, 11) . '</b></span><h3>' . lang('index.voucher.createdHelp') . '</h3></div>' : '' ?>
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle"></i> <?= lang('index.status.title') ?>
                </div>
            </div>
            <div class="card-body text-center">
                <?php if ($clientsConnected == 0): ?>
                    <h2><?= sprintf(lang('index.status.connected.none')) ?></h2>
                <?php elseif ($clientsConnected == 1): ?>
                    <h2><?= sprintf(lang('index.status.connected.singular')) ?></h2>
                <?php else: ?>
                    <h2><?= sprintf(lang('index.status.connected.plural'), $clientsConnected) ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.voucher.title') ?>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('createVoucher') ?>
                <div class="mb-3">
                    <label for="quota" class="form-label"><?= lang('index.voucher.quota.label') ?> </label>
                    <div class="progress" style="height: 30px; font-size: 15px">
                        <div id="quotaBar" class="progress-bar" role="progressbar"></div>
                    </div>
                    <input type="range" min="1" max="<?= getenv('voucher.maxQuota') ?>" step="1"
                           value="<?= getenv('voucher.defaultQuota') ?>" class="form-range"
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
                    <input type="range" min="1" max="<?= getenv('voucher.maxDuration') ?>" step="1"
                           value="<?= getenv('voucher.defaultDuration') ?>" class="form-range"
                           name="duration"
                           id="duration"
                           alt="<?= lang('index.voucher.duration.unit') ?>"
                           onchange="update(this)"
                           required>
                </div>

                <button type="submit" class="btn btn-primary"><?= lang('index.voucher.button') ?></button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
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
                    <?php foreach ($vouchers as $voucher) : ?>
                        <tr>
                            <td onmouseenter="blurText(this, false)" onmouseleave="blurText(this, true)"
                                class="blurred"><?= $voucher->code ?></td>
                            <td><?= $voucher->quota - $voucher->used ?></td>
                            <td><?= $voucher->duration ?></td>
                            <td><?= date("d.m.Y H:i", $voucher->create_time) ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirmRedirect('<?= base_url('admin/vouchers/delete') . '?id=' . $voucher->_id . '&returnUrl=/' ?>')">
                                    <i class="fas fa-trash"></i> <?= lang('vouchers.list.delete') ?>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
        if (confirm('<?= lang('app.confirm') ?>')) {
            window.location.href = url;
        }
    }

    function blurText(element, blur) {
        if (blur) {
            element.classList.replace('visible', 'blurred');
        } else {
            element.classList.replace('blurred', 'visible');
        }
    }
</script>