<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <?= !empty(session('student')) ? '<div class="alert alert-success mb-3 text-center"> <i class="fas fa-check-circle fa-5x"></i><br/><h1>' . lang('students.created') . '</h1><h4>' . session('student')->name . '</h4></div>' : '' ?>
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('students.error.title') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('students.error.title') . '</b> ' . session('error') . '</div>' : '' ?>
        <?= !empty(session('info')) ? '<div class="alert alert-info mb-3"> <i class="fas fa-circle-info"></i> <b>' . lang('students.info.title') . '</b> ' . session('info') . '</div>' : '' ?>


        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-square-plus"></i> <?= lang('students.create.title') ?>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('admin/students/create') ?>
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= lang('students.create.name') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="namePrepend"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="name" id="name"
                                   aria-describedby="namePrepend" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="print" name="print" checked>
                            <label class="form-check-label" for="print"><?= lang('students.create.print') ?></label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('students.create.button') ?></button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-graduation-cap"></i> <?= lang('students.list.title') ?>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('students.list.username') ?></th>
                        <th scope="col"><?= lang('students.list.password') ?></th>
                        <th scope="col"><?= lang('students.list.clients') ?></th>
                        <th scope="col"><?= lang('students.list.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student) : ?>
                        <tr>
                            <td><?= $student->name ?></td>
                            <td onmouseenter="blurText(this, false)" onmouseleave="blurText(this, true)"
                                class="blurred"><?= $student->x_password ?></td>
                            <td>
                                <ul>
                                    <?php if ($student->devices) : ?>
                                        <?php foreach ($student->devices as $key => $value) : ?>
                                            <li><?= $key ?> <span class="badge bg-<?= $value ? 'success' : 'danger' ?>">
                                                <?= lang('students.list.online.' . ($value ? 'true' : 'false')) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?= lang('students.list.noDevices') ?>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm mr-2"
                                        onclick="confirmRedirect('<?= base_url('admin/students/delete') . '?id=' . $student->_id ?>')">
                                    <i class="fas fa-trash"></i> <?= lang('students.list.delete') ?>
                                </button>
                                <a class="btn btn-primary btn-sm mr-2"
                                   href="<?= base_url('admin/students/print') . '?id=' . $student->_id ?>">
                                    <i class="fas fa-print"></i> <?= lang('students.list.print') ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRedirect(url) {
        if (confirm('<?= lang('app.confirm') ?>')) {
            window.location.href = url;
        }
    }

    function blurText(element, blur) {
        if (blur) {
            element.classList.replace('visible', 'blurred');
        } else {
            element.classList.replace('blurred', 'visible');
        }
    }
</script>