<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="alert alert-warning mb-3">
            <h5><?= lang('index.disclaimer.title') ?></h5>
            <?= lang('index.disclaimer.text') ?>
        </div>

        <?= !empty(session('voucher')) ? '<div class="alert alert-success mb-3 text-center"> <i class="fas fa-check-circle fa-5x"></i><br/><h1>' . lang('index.voucher.created') . '</h1><h4>' . session('voucher')->code . '</h4></div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-ticket"></i> <?= lang('index.voucher.title') ?>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/createVoucher') ?>" method="POST">
                    <div class="mb-3">
                        <label for="quota" class="form-label"><?= lang('index.voucher.quota.label') ?> </label>
                        <div class="progress" style="height: 30px; font-size: 15px">
                            <div id="quotaBar" class="progress-bar" role="progressbar"></div>
                        </div>
                        <input type="range" min="1" max="40" step="1" value="10" class="form-range"
                               name="quota"
                               id="quota"
                               alt="<?= lang('index.voucher.quota.unit') ?>"
                               onchange="update(this)"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label"><?= lang('index.voucher.duration.label') ?> </label>
                        <div class="progress" style="height: 30px; font-size: 15px">
                            <div id="durationBar" class="progress-bar" role="progressbar"></div>
                        </div>
                        <input type="range" min="1" max="180" step="1" value="45" class="form-range"
                               name="duration"
                               id="duration"
                               alt="<?= lang('index.voucher.duration.unit') ?>"
                               onchange="update(this)"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('index.voucher.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll('input[type=range]');
        for (let i = 0; i < elements.length; i++) {
            update(elements[i])
        }
    });

    function update(element) {
        const bar = document.getElementById(element.id + 'Bar');
        bar.textContent = element.value + ' ' + element.alt;
        bar.style.width = ((element.value / element.max) * 100) + '%';
    }
</script>