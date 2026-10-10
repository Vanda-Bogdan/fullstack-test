<?php if (empty($comments)): ?>
    <p class="text-muted font-italic">Пока комментариев нет.</p>
<?php else: ?>
    <?php foreach ($comments as $comment): ?>
        <div class="card mb-3" data-comment-id="<?= $comment['id'] ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong><?= esc($comment['user_email']) ?></strong><small
                                class="ml-2">ID: <?= esc($comment['id']) ?></small>
                    </div>

                    <?php if (session()->get('user_id') == $comment['user_id']): ?>
                        <button type="button" class="btn btn-sm btn-link text-danger delete-comment">
                            Удалить
                        </button>
                    <?php endif; ?>
                </div>
                <div style="white-space: pre-wrap;"><?= esc($comment['text']) ?></div>
                <div class="text-muted comment-date mt-4"
                     data-utc-date="<?= str_replace(' ', 'T', esc($comment['date'])) ?>Z">
                    <?= esc($comment['date']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links('default', 'bootstrap4') ?>
    </div>
<?php endif; ?>
