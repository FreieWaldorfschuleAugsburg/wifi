<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <?= lang('app.name') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMobileToggle">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown" <?= $user->admin ? '' : 'hidden' ?>>
                    <a class="nav-link dropdown-toggle" id="adminMenu" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-tachometer-alt"></i> <?= lang('menu.admin') ?>
                    </a>
                    <ul class="dropdown-menu rounded-3" aria-labelledby="adminMenu">
                        <li><a class="dropdown-item" href="<?= base_url('admin/vouchers') ?>"><i class="fas fa-ticket"></i>
                                <?= lang('menu.admin.vouchers') ?></a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/students') ?>"><i class="fas fa-graduation-cap"></i>
                                <?= lang('menu.admin.students') ?></a></li>
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