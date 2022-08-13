<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('students.title') ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('students.username') ?></th>#
                        <th scope="col"><?= lang('students.password') ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    echo '<pre>';
                    print_r($students);
                    echo '</pre>';
                    foreach ($students as $student) {
                        echo '<tr>';
                        echo '<td>' . $student->name . '</td>';
                        echo '<td>' . $student->x_password . '</td>';
                        echo '<td><button class="btn btn-danger btn-sm" onclick="confirmRedirect(\'' . base_url('admin/students/delete') . '?id=' . $student->_id . '\')"><i class="fas fa-trash"></i> Löschen</button>';
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
</script>