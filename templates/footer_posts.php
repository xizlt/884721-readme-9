
<footer class="post__footer post__indicators">
    <div class="post__buttons">
        <a class="post__indicator post__indicator--likes button" href="add_like.php?post_id=<?=$post['id'];?>" title="Лайк">
            <?php $like_check = get_like_by_user($connection, $post['id'], $user['id']); ?>
            <svg class="post__indicator-icon" width="20" height="17">
                <use xlink:href="#icon-heart<?php if ($like_check): ?>-active<?php endif;?>"></use>
            </svg>
            <span><?= $post['like_post']; ?></span>
            <span class="visually-hidden">количество лайков</span>
        </a>
        <a class="post__indicator post__indicator--comments button" href="post.php?id=<?=$post['id']?>" title="Комментарии">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-comment"></use>
            </svg>
            <span><?= get_count_comments($connection, $post['id']);?></span>
            <span class="visually-hidden">количество комментариев</span>
        </a>
        <a class="post__indicator post__indicator--repost button" href="add_repost.php?post_id=<?=$post['id'];?>" title="Репост">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-repost"></use>
            </svg>
            <span><?= $post['repost']; ?></span>
            <span class="visually-hidden">количество репостов</span>
        </a>
    </div>
</footer>

