<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Вход<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-4 text-center">Вход</h1>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('login') ?>">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 mb-0">
                Нет аккаунта? <a href="<?= site_url('register') ?>">Зарегистрироваться</a>
            </p>
        </div>
    </div>
<?= $this->endSection() ?>