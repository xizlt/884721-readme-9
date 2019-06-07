<?php $profile = get_user_by_id($connection, $post['repost_doner_id']);?>
<header class="post__header">
    <div class="post__author">
        <a class="post__author-link" href="profile.php?id=<?= $profile['id'];?>" title="Автор">
            <div class="post__avatar-wrapper post__avatar-wrapper--repost">
                <?php if ($profile['avatar']): ?><img class="post__author-avatar" src="<?=$profile['avatar']?>" alt="Аватар пользователя"><?php endif; ?>
            </div>
            <div class="post__info">
                <b class="post__author-name">Репост: <?=$profile['name']; ?></b>
                <time class="post__time" datetime="<?= $post['create_time'];?>"><?= publication_date($post['create_time']);?></time>
            </div>
        </a>
    </div>
</header>
