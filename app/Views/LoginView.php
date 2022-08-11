<div class="container px-4 mt-4">
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-8">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="100" height="100" alt="" class="mx-auto d-block">
            <h1 class="text-center mb-5"><?= lang('app.name') ?></h1>

            <div class="card">
                <div class="card-header">
                    <?= lang('loginView.cardTitle') ?>
                </div>
                <div class="card-body">
                    <?= session('error') ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> ' . lang(session('error')) . '</div>' : '' ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label"><?= lang('loginView.username') ?></label>
                            <div class="input-group">
                                <span class="input-group-text" id="usernamePrepend"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="username" id="username"
                                       aria-describedby="usernamePrepend" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?= lang('loginView.password') ?></label>
                            <div class="input-group">
                                <span class="input-group-text" id="passwordPrepend"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" name="password" id="password"
                                       aria-describedby="passwordPrepend" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= lang('loginView.button') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>