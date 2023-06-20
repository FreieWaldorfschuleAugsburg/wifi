<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="theme-color" content="#111111" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#eeeeee" media="(prefers-color-scheme: dark)">

    <title><?= lang('app.name.short') ?></title>

    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <meta name="color-scheme" content="light dark">

    <link href="<?= base_url('/') ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap-dark-plugin.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <link rel="stylesheet" href="<?= base_url('/') ?>/assets/css/fontawesome.min.css"/>

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
            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body>