<?php

use App\Models\OAuthException;
use function App\Helpers\user;

?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('app.name.short') ?></title>

    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/') ?>/assets/css/fontawesome.min.css"/>

    <link href="<?= base_url('/') ?>/assets/css/style.css" rel="stylesheet">

    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            var u = "//matomo.waldorf-augsburg.de/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '2']);

            <?php if (function_exists('user') && $user = user()): ?>
            _paq.push(['setUserId', '<?= $user->username ?>'])
            <?php endif; ?>

            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body>