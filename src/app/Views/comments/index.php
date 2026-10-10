<?php
function sort_link(string $column, string $label, string $currentSort, string $currentDir): string
{
    $newDir = ($currentSort === $column && $currentDir === 'asc') ? 'desc' : 'asc';
    $url = site_url('/') . '?sort=' . $column . '&dir=' . $newDir;
    $arrow = '';
    if ($currentSort === $column) {
        $arrow = $currentDir === 'asc' ? ' ↑' : ' ↓';
    }
    return '<a href="' . $url . '" class="btn btn-sm btn-outline-secondary">' . $label . $arrow . '</a>';
}
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Комментарии<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1 class="h3 mb-4">Комментарии</h1>

<div class="mb-3 d-flex align-items-center">
    <span class="mr-2 text-muted">Сортировать:</span>
    <?= sort_link('id',   'По ID',   $sort, $dir) ?>
    <?= sort_link('date', 'По дате', $sort, $dir) ?>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

    <div id="comments-list">
        <?= $this->include('comments/list', ['comments' => $comments, 'pager' => $pager]) ?>
    </div>

    <hr class="my-4">


<?php if (session()->get('user_id')): ?>
    <h2 class="h5 mb-3">Оставить комментарий</h2>

    <?php $errors = session()->getFlashdata('error'); ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 pl-3">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('commentsAjax') ?>" id="comment-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="text">Текст комментария</label>
            <textarea name="text"
                      id="text"
                      rows="4"
                      class="form-control"
                      maxlength="200"
                      required><?= old('text') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
<?php else: ?>
    <div class="alert alert-info mb-0">
        Чтобы оставить комментарий, <a href="<?= site_url('login') ?>">войдите</a>.
    </div>
<?php endif; ?>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        const $form = $('#comment-form');
        const $list = $('#comments-list');
        const $errors = $('#form-errors');

        $form.on('submit', function (e) {
            e.preventDefault();

            $errors.html('');
            $('#text-error').text('');
            $('#text').removeClass('is-invalid');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json'
            })
                .done(function (response) {
                    $.get('<?= site_url('comments/list') ?>', function (response) {
                        $('#comments-list').html(response.list);
                        formatDates(document.getElementById('comments-list'));
                    }, 'json');
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors || {};
                        if (errors.text) {
                            $('#text').addClass('is-invalid');
                            $('#text-error').text(errors.text);
                        }
                    } else if (xhr.status === 401) {
                        $errors.html('<div class="alert alert-danger">' + xhr.responseJSON.error + '</div>');
                    } else {
                        $errors.html('<div class="alert alert-danger">Что-то пошло не так. Попробуйте ещё раз.</div>');
                    }
                });
        });
    });


    $(document).on('click', '.delete-comment', function () {
        const $card = $(this).closest('.card');
        const id = $card.data('comment-id');

        if (!confirm('Удалить комментарий?')) {
            return;
        }

        $.ajax({
            url: '<?= site_url('comments') ?>/' + id + '/delete',
            method: 'POST',
            data: { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
            dataType: 'json'
        })
            .done(function () {
                $.get('<?= site_url('comments/list') ?>', function (response) {
                    $('#comments-list').html(response.list);
                    formatDates(document.getElementById('comments-list'));
                }, 'json');
            })
            .fail(function (xhr) {
                const msg = (xhr.responseJSON && xhr.responseJSON.error)
                    ? xhr.responseJSON.error
                    : 'Не удалось удалить комментарий.';
                alert(msg);
            });
    });
</script>

<script>
    // document.addEventListener("DOMContentLoaded", () => {
    //     const dateElements = document.querySelectorAll('.comment-date');
    //
    //     dateElements.forEach(element => {
    //         const rawDate = element.getAttribute('data-utc-date');
    //
    //         if (rawDate) {
    //             const date = new Date(rawDate);
    //
    //             if (!isNaN(date.getTime())) {
    //                 element.textContent = date.toLocaleString(navigator.language, {
    //                     dateStyle: 'short',
    //                     timeStyle: 'short'
    //                 });
    //             }
    //         }
    //     });
    // });

</script>

<?= $this->endSection() ?>
