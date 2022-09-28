<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('app.name') ?></title>

    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>
<div class="container px-4 mt-4">
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-8 text-center">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="100" height="100" alt="" class="mx-auto d-block">
            <h1 class="mb-5"><?= lang('app.name.headline') ?></h1>
            <hr>
            <h4><?= lang('app.error.exception.title') ?></h4>
            <p><?= lang('app.error.exception.text') ?></p>
            <hr>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <p class="text-muted"><?= lang('app.copyright') ?></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
