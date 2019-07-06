<footer class="post__footer">
    <div class="post__indicators">
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
            <a class="post__indicator post__indicator--repost button" href="add_repost.php?post_id=<?= $post['id']; ?>"
               title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                    <use xlink:href="#icon-repost"></use>
                </svg>
                <span><?= $post['repost']; ?></span>
                <span class="visually-hidden">количество репостов</span>
            </a>
        </div>
        <time class="post__time"
              datetime="<?= $post['create_time']; ?>"><?= publication_date($post['create_time']); ?></time>
    </div>
    <ul class="post__tags">
        <?php $tags = get_tag_by_id($connection, $post['id']) ?? null; ?>
        <?php if ($tags): ?>
            <?php foreach ($tags as $tag): ?>
                <?php $tag_word = get_tags($connection, $tag['tag_id']); ?>
                <li>
                    <a href="search.php?search=<?= urlencode('#') . $tag_word['name']; ?>"><?= '#' . $tag_word['name']; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</footer>

