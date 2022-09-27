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
                <form action="<?= base_url('/admin/students/create') ?>" method="POST">
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
                </form>
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
                        <th scope="col"><?= lang('students.list.connectedClients') ?></th>
                        <th scope="col"><?= lang('students.list.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($students as $student) {
                        echo '<tr>';
                        echo '<td>' . $student->name . '</td>';
                        echo '<td onmouseenter="blurText(this, false)" onmouseleave="blurText(this, true)" style="color: transparent; text-shadow: 0 0 10px rgba(0,0,0,0.5);">' . $student->x_password . '</td>';
                        echo '<td>' . $student->clients . '</td>';
                        echo '<td>' . $student->connectedClients . '</td>';
                        echo '<td><a class="btn btn-danger btn-sm" href="javascript:confirmRedirect(\'' . base_url('admin/students/delete') . '?id=' . $student->_id . '\')"><i class="fas fa-trash"></i> ' . lang('students.list.delete') . '</a>&nbsp;';
                        echo '<a class="btn btn-primary btn-sm" href="' . base_url('admin/students/print') . '?id=' . $student->_id . '"><i class="fas fa-print"></i> ' . lang('students.list.print') . '</button></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRedirect(url) {
        if (confirm('<?= lang('students.confirm') ?>')) {
            window.location.href = url;
        }
    }

    function blurText(element, blur) {
        element.style.color = (blur ? 'transparent' : 'black');
    }
</script>