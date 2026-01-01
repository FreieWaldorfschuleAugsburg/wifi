<?php include_once __DIR__ . '/../../components/header.php'; ?>

    <div class="container px-4 mt-4">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <img src="<?= base_url('/') ?>/assets/img/logo.png" width="100" height="100" alt="" class="mx-auto d-block">
                <h1 class="mb-5"><?= lang('app.name.headline') ?></h1>
                <hr>
                <h4><?= lang('app.error.400.title') ?></h4>
                <p><?= lang('app.error.400.text') ?><br/>
                    <a href="<?= base_url('/') ?>">Klicken Sie hier, um zur Startseite zu gelangen.</a>
                </p>
                <hr>
            </div>
        </div>
    </div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>