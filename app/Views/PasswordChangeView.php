<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-key"></i> <?= lang('passwordChangeView.cardTitle') ?>
                </div>
            </div>
            <div class="card-body">
                <?= session('error') ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> ' . lang(session('error')) . '</div>' : '' ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= lang('passwordChangeView.password') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="passwordPrepend"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" name="password" id="password"
                                   aria-describedby="passwordPrepend" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="repeatedPassword" class="form-label"><?= lang('passwordChangeView.repeatPassword') ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="repeatedPasswordPrepend"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" name="repeatedPassword" id="repeatedPassword"
                                   aria-describedby="repeatedPasswordPrepend" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('passwordChangeView.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>