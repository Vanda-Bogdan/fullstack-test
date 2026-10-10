<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Вход<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-4 text-center">Регистрация</h1>

                <?php $errors = session()->getFlashdata('errors'); ?>
                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('register') ?>">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               value="<?= old('email') ?>"
                               required
                               autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               required>
                        <small class="form-text text-muted">Минимум 6 символов.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                </form>
            </div>
        </div>

        <p class="text-center mt-3 mb-0">
            Уже есть аккаунт? <a href="<?= site_url('login') ?>">Войти</a>
        </p>

    </div>
</div>
<?= $this->endSection() ?>



