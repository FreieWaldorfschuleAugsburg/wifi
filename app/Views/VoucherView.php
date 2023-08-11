<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <?= !empty(session('voucher')) ? '<div class="alert alert-success mb-3 text-center"> <i class="fas fa-check-circle fa-5x"></i><br/><h1>' . lang('vouchers.created') . '</h1><h4>' . session('voucher')->code . '</h4></div>' : '' ?>
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('vouchers.error.title') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('vouchers.error.title') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-square-plus"></i> <?= lang('vouchers.create.title') ?>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('admin/vouchers/create') ?>
                    <div class="mb-3">
                        <label for="quota" class="form-label"><?= lang('vouchers.create.quota') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="quotaPrepend"><i class="fas fa-users"></i></span>
                            <input type="number" class="form-control" name="quota" id="quota"
                                   aria-describedby="quotaPrepend" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label"><?= lang('vouchers.create.duration.label') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            <input type="number" class="form-control" name="duration" id="duration" required>

                            <select class="form-select" name="unit" id="unit">
                                <option value="1" selected><?= lang('vouchers.create.duration.minutes') ?></option>
                                <option value="60"><?= lang('vouchers.create.duration.hours') ?></option>
                                <option value="1440"><?= lang('vouchers.create.duration.days') ?></option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('vouchers.create.button') ?></button>
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
                    <i class="fas fa-ticket"></i> <?= lang('vouchers.list.title') ?>
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
                        <th scope="col"><?= lang('vouchers.list.creator') ?></th>
                        <th scope="col"><?= lang('vouchers.list.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($vouchers as $voucher) : ?>
                        <tr>
                            <td onmouseenter="blurText(this, false)" onmouseleave="blurText(this, false)"
                                class="blurred"><?= $voucher->code ?></td>
                            <td><?= $voucher->quota ?></td>
                            <td><?= $voucher->duration ?></td>
                            <td><?= date("d.m.Y H:i", $voucher->create_time) ?></td>
                            <td><?= $voucher->note ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirmRedirect('<?= base_url('admin/vouchers/delete') . '?id=' . $voucher->_id ?>&returnUrl=admin/vouchers')">
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