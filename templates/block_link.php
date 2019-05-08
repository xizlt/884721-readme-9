<div class="post__main">
    <div class="post-link__wrapper">
        <a class="post-link__external" href="http://www.vitadental.ru" title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="img/logo-vita.jpg" alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= clean($post['title']); ?></h3>
                    <p><?= clean($post['message']); ?></p>
                </div>
            </div>
            <span><?= clean($post['link']); ?></span>
        </a>
    </div>
</div>
