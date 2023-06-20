<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top"
                 alt="">
            <?= lang('app.name.short') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMobileToggle">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isVoucherEnabled($user->currentSite)): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/vouchers') ?>"><i class="fas fa-ticket"></i>
                            <?= lang('menu.admin.vouchers') ?></a>
                    </li>
                <?php endif; ?>
                <?php if (isStudentEnabled($user->currentSite)): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/students') ?>"><i
                                    class="fas fa-graduation-cap"></i>
                            <?= lang('menu.admin.students') ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sitemap"></i> <?= $user->getSiteName() ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php foreach ($user->sitesAvailable as $site): ?>
                            <li><a class="dropdown-item"
                                   href="<?= base_url('site') ?>?site=<?= $site ?>"><?= getSiteProperty($site, 'name') ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> <?= $user->displayName ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i
                                        class="fas fa-sign-out-alt"></i> <?= lang('menu.self.logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container px-4 mt-4">