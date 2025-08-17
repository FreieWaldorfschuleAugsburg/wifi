<div class="container px-4 mt-4">
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-8">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="100" height="100" alt="" class="mx-auto d-block">
            <h1 class="text-center mb-5"><?= lang('app.name.headline') ?></h1>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-sign-in-alt"></i> <b><?= lang('loginError.title') ?></b>
                </div>
                <div class="card-body">
                    <?= !empty($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> ' . $error . '</div>' : '' ?>
                </div>
            </div>
        </div>
    </div>
</div>