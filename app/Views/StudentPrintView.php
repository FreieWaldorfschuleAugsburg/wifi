<div class="container px-4">
    <div class="row justify-content-center mt-3">
        <div class="col-lg-12">
            <h1 class="text-center"><?= lang('app.name') ?></h1>
            <h5 class="text-center mb-5"><?= lang('students.print.subtitle') ?></h5>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-key"></i> <b><?= lang('students.print.credentials.title') ?></b>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label"><?= lang('students.print.credentials.username') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="usernamePrepend"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="username" id="username" value="<?= $student->name ?>"
                                   aria-describedby="usernamePrepend" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= lang('students.print.credentials.password') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="passwordPrepend"><i class="fas fa-key"></i></span>
                            <input type="text" class="form-control" name="password" id="password" value="<?= $student->x_password ?>"
                                   aria-describedby="passwordPrepend" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-tasks"></i> <b><?= lang('students.print.manual.title') ?></b>
                </div>
                <div class="card-body">
                    <?= lang('students.print.manual.text') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-section"></i> <b><?= lang('students.print.terms.title') ?></b>
                </div>
                <div class="card-body">
                    <?= lang('students.print.terms.text') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.onafterprint = () => {
            window.location.href = "/admin/students";
        }

        window.print();
    });
</script>