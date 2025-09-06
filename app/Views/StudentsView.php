<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('students.error.title') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('students.error.title') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-square-plus"></i> <?= lang('students.create.title') ?>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('admin/students/create') ?>

                <div class="mb-3">
                    <label for="duration" class="form-label"><?= lang('students.create.student') ?></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                        <select class="form-select" name="username" id="username">
                            <?php foreach ($allStudents as $student) : ?>
                                <option value="<?= $student['samaccountname'][0] ?>"><?= $student['cn'][0] ?></option>
                            <?php endforeach; ?>
                        </select>
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
                    <i class="fas fa-ticket"></i> <?= lang('students.list.title') ?>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('students.list.username') ?></th>
                        <th scope="col"><?= lang('students.list.fullName') ?></th>
                        <th scope="col"><?= lang('students.list.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($activeStudents as $student) : ?>
                        <tr>
                            <td><?= $student['samaccountname'][0] ?></td>
                            <td><?= $student['cn'][0] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirmRedirect('<?= base_url('admin/students/delete') . '?username=' . $student['samaccountname'][0] ?>')">
                                    <i class="fas fa-trash"></i> <?= lang('students.list.delete') ?>
                                </button>
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
</script>