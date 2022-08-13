<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.title') ?>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/') ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label"><?= lang('login.username') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="usernamePrepend"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="username" id="username"
                                   aria-describedby="usernamePrepend" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('indexView.createVoucher') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>