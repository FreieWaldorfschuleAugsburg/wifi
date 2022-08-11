<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('indexView.cardTitle') ?>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/') ?>" method="POST">
                    <div class="mb-3">
                        <label for="voucherUsages" class="form-label"><?= lang('indexView.voucherUsages') ?></label>
                        <input type="number" class="form-control" id="voucherUsages" name="voucherUsages"
                               aria-describedby="usagesHelp" required>
                        <div id="usagesHelp" class="form-text"><?= lang('indexView.voucherUsagesHelp') ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="voucherExpire" class="form-label"><?= lang('indexView.voucherExpire') ?></label>
                        <input type="datetime-local" class="form-control" id="voucherExpire" name="voucherExpire"
                               aria-describedby="voucherExpireHelp" required>
                        <div id="voucherExpireHelp" class="form-text"><?= lang('indexView.voucherExpireHelp') ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('indexView.createVoucher') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>