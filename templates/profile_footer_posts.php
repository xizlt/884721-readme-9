<footer class="post__footer">
    <div class="post__indicators">
        <div class="post__buttons">
            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                    <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                    <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span>250</span>
                <span class="visually-hidden">количество лайков</span>
            </a>
            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                    <use xlink:href="#icon-repost"></use>
                </svg>
                <span>5</span>
                <span class="visually-hidden">количество репостов</span>
            </a>
        </div>
        <time class="post__time" datetime="2019-01-30T23:41">15 минут назад</time>
    </div>
    <ul class="post__tags">
        <?php $tags = get_tag_by_id($connection, $post['id']); ?>
        <?php if ($tags): ?>
            <?php foreach ($tags as $tag): ?>
                <?php $tag_word = get_tags($connection, $tag['tag_id']); ?>
                <li><a href="#">#<?= $tag_word['name']; ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</footer>

