<div class="post__main">
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= $post['link']; ?>" title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="img/logo-vita.jpg" alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= $post['title']; ?></h3>
                    <p><?= $post['message']; ?></p>
                </div>
            </div>
            <span><?= $post['link']; ?></span>
        </a>
    </div>
</div>
