<header class="post__header post__author">
    <a class="post__author-link" href="profile.php?id=<?= $post['user']; ?>" title="Автор">
        <div class="post__avatar-wrapper">
            <?php if ($post['avatar']): ?><img class="post__author-avatar" src="<?= $post['avatar']; ?>"
                                               alt="Аватар пользователя" width="60" height="60"><?php endif; ?>
        </div>
        <div class="post__info">
            <b class="post__author-name"><?= $post['user_name']; ?></b>
            <span class="post__time"><?= publication_date($post['create_time']); ?></span>
        </div>
    </a>
</header>
