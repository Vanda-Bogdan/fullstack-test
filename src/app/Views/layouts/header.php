<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
<!--        <a class="navbar-brand" href="--><?php //= site_url('comments') ?><!--">Мой сайт</a>-->

        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('/') ?>">Комментарии</a>
                </li>
            </ul>

            <?php if (session()->get('user_id')): ?>
                <ul class="navbar-nav ml-auto align-items-md-center">
                    <li class="nav-item mr-md-3">
                        <span class="navbar-text text-light">
                            <?= esc(session()->get('user_email')) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= site_url('logout') ?>">Выйти</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('login') ?>">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('register') ?>">Регистрация</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>