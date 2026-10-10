<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> - Тестовый сайт</title>

    <link rel="stylesheet" href="<?= base_url('css/bootstrap.css')?>">
</head>
<body class="bg-light">

<?= $this->include('layouts/header') ?>

<div class="container mt-4">
    <?= $this->renderSection('content') ?>
</div>

<script src="<?= base_url('js/jquery-3.7.1.min.js')?>"></script>
<script src="<?= base_url('js/popper.js')?>"></script>
<script src="<?= base_url('js/bootstrap.js')?>"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>