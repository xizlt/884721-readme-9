<footer class="post__footer post__indicators">
    <div class="post__buttons">
        <?php $like_check = get_like_by_user($connection, $post['id'], $user['id']); ?>

        <a class="post__indicator post__indicator--likes button" href="add_like.php?post_id=<?= $post['id']; ?>" title="Лайк">
            <svg class="post__indicator-icon <?php if($like_check === 0):?>post__indicator-icon--like-active<?php endif;?>" width="20" height="17">
                <use xlink:href="#icon-heart-active"></use>
            </svg>
            <?php if($like_check === 0):?>
                <svg class="post__indicator-icon" width="20" height="17">
                    <use xlink:href="#icon-heart"></use>
                </svg>
            <?php endif;?>
            <span><?= get_count_likes($connection, $post['id']); ?></span>
            <span class="visually-hidden">количество лайков</span>
        </a>
        <a class="post__indicator post__indicator--comments button" href="post.php?id=<?= $post['id'] ?>"
           title="Комментарии">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-comment"></use>
            </svg>
            <span><?= get_count_comments($connection, $post['id']); ?></span>
            <span class="visually-hidden">количество комментариев</span>
        </a>
        <a class="post__indicator post__indicator--repost button" href="add_repost.php?post_id=<?= $post['id']; ?>"
           title="Репост">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-repost"></use>
            </svg>
            <span><?= $post['repost']; ?></span>
            <span class="visually-hidden">количество репостов</span>
        </a>
    </div>
</footer>

