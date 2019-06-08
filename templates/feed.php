<main class="page__main page__main--feed">
    <div class="container">
        <h1 class="page__title page__title--feed">Моя лента</h1>
    </div>
    <div class="page__main-wrapper container">
        <section class="feed">
            <h2 class="visually-hidden">Лента</h2>
            <div class="feed__main-wrapper">
                <div class="feed__wrapper">
                    <?php foreach ($posts as $post): ?>
                    <?php if ($post['type'] === 'post-photo'): ?>
                    <article class="feed__post post post-photo">
                        <?php require 'header_posts.php'; ?>
                        <div class="post__main">
                            <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title'];?></a></h2>
                            <div class="post-photo__image-wrapper">
                                <img src="<?= $post['image'];?>" alt="Фото от пользователя" width="760" height="396">
                            </div>
                        </div>
                        <?php require 'footer_posts.php'; ?>
                    </article>

                    <?php elseif($post['type'] === 'post-text'): ?>
                    <article class="feed__post post post-text">
                        <?php require 'header_posts.php'; ?>
                        <div class="post__main">
                            <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title'];?></a></h2>
                            <p>
                                <?= clips_text($post['message'], $post['id']);?>
                            </p>
                        </div>
                        <?php require 'footer_posts.php'; ?>
                    </article>

                    <?php elseif($post['type'] === 'post-video'): ?>
                    <article class="feed__post post post-video">
                        <?php require 'header_posts.php'; ?>

                        <div class="post__main">
                            <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title'];?></a></h2>
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?= embed_youtube_video($post['video']); ?>
                                </div>
                            </div>
                        </div>

                        <?php require 'footer_posts.php'; ?>
                    </article>

                    <?php elseif($post['type'] === 'post-quote'): ?>
                    <article class="feed__post post post-quote">
                        <?php require 'header_posts.php'; ?>
                        <div class="post__main">
                            <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title'];?></a></h2>
                            <blockquote>
                                <p>
                                    <?= $post['message'];?>
                                </p>
                                <cite><?= $post['quote_writer'];?></cite>
                            </blockquote>
                        </div>
                        <?php require 'footer_posts.php'; ?>
                    </article>

                    <?php elseif($post['type'] === 'post-link'): ?>
                    <article class="feed__post post post-link">
                        <?php require 'header_posts.php'; ?>
                        <div class="post__main">
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="<?= $post['link'];?>" title="Перейти по ссылке">
                                    <div class="post-link__icon-wrapper">
                                        <img src="img/logo-vita.jpg" alt="Иконка">
                                    </div>
                                    <div class="post-link__info">
                                        <h3><?= $post['title'];?></h3>
                                        <p><?= $post['message'];?></p>
                                        <span><?= $post['link'];?></span>
                                    </div>
                                    <svg class="post-link__arrow" width="11" height="16">
                                        <use xlink:href="#icon-arrow-right-ad"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?php require 'footer_posts.php'; ?>
                    </article>
                    <?php endif; ?>
                    <?php endforeach;?>
                </div>
            </div>
            <ul class="feed__filters filters">
                <li class="feed__filters-item filters__item">
                    <a class="filters__button filters__button--ellipse filters__button--all <?php if(empty($type_id)): ?> filters__button--active <?php endif;?>" href="feed.php">
                        <span>Все</span>
                    </a>
                </li>
                <?php foreach ($types as $type): ?>
                    <?php if ($type['name'] === 'post-photo'): ?>
                        <li class="feed__filters-item filters__item">
                            <a class="filters__button filters__button--photo button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="feed.php?type_id=<?= $type['id']; ?>">
                                <span class="visually-hidden">Фото</span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-photo"></use>
                                </svg>
                            </a>
                        </li>

                    <?php elseif ($type['name'] === 'post-video'): ?>
                        <li class="feed__filters-item filters__item">
                            <a class="filters__button filters__button--video button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="feed.php?type_id=<?= $type['id']; ?>">
                                <span class="visually-hidden">Видео</span>
                                <svg class="filters__icon" width="24" height="16">
                                    <use xlink:href="#icon-filter-video"></use>
                                </svg>
                            </a>
                        </li>

                    <?php elseif ($type['name'] === 'post-text'): ?>
                        <li class="feed__filters-item filters__item">
                            <a class="filters__button filters__button--text button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="feed.php?type_id=<?= $type['id']; ?>">
                                <span class="visually-hidden">Текст</span>
                                <svg class="filters__icon" width="20" height="21">
                                    <use xlink:href="#icon-filter-text"></use>
                                </svg>
                            </a>
                        </li>

                    <?php elseif ($type['name'] === 'post-quote'): ?>
                        <li class="feed__filters-item filters__item">
                            <a class="filters__button filters__button--quote button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="feed.php?type_id=<?= $type['id']; ?>">
                                <span class="visually-hidden">Цитата</span>
                                <svg class="filters__icon" width="21" height="20">
                                    <use xlink:href="#icon-filter-quote"></use>
                                </svg>
                            </a>
                        </li>

                    <?php elseif ($type['name'] === 'post-link'): ?>
                        <li class="feed__filters-item filters__item">
                            <a class="filters__button filters__button--link button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="feed.php?type_id=<?= $type['id']; ?>">
                                <span class="visually-hidden">Ссылка</span>
                                <svg class="filters__icon" width="21" height="18">
                                    <use xlink:href="#icon-filter-link"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </section>
        <aside class="promo">
            <article class="promo__block promo__block--barbershop">
                <h2 class="visually-hidden">Рекламный блок</h2>
                <p class="promo__text">
                    Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
                </p>
                <a class="promo__link" href="#">
                    Подробнее
                </a>
            </article>
            <article class="promo__block promo__block--technomart">
                <h2 class="visually-hidden">Рекламный блок</h2>
                <p class="promo__text">
                    Товары будущего уже сегодня в онлайн-сторе Техномарт!
                </p>
                <a class="promo__link" href="#">
                    Перейти в магазин
                </a>
            </article>
            <article class="promo__block">
                <h2 class="visually-hidden">Рекламный блок</h2>
                <p class="promo__text">
                    Здесь<br> могла быть<br> ваша реклама
                </p>
                <a class="promo__link" href="#">
                    Разместить
                </a>
            </article>
        </aside>
    </div>
</main>
