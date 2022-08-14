<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.voucher.title') ?>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/') ?>" method="POST">
                    <div class="mb-3">
                        <label for="quota" class="form-label"><?= lang('index.voucher.quota') ?></label>
                        <label for="quotaDisplay"></label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <input type="range" min="0" max="180" value="0" class="form-control form-range" name="quota"
                                   id="quota" required>

                            <input type="text" class="form-control" id="quotaDisplay" value="0" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label"><?= lang('vouchers.create.duration.label') ?></label>
                        <label for="durationDisplay"></label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            <input type="range" min="0" max="180" value="0" class="form-control form-range" name="duration"
                                   id="duration" required>

                            <input type="text" class="form-control" id="durationDisplay" value="0 <?= lang('index.voucher.duration.unit') ?>" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('index.voucher.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>