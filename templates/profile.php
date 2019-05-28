
<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <?php if ($user_profile['avatar']): ?><img class="profile__picture user__picture" src="<?= $user_profile['avatar'];?>" alt="Аватар пользователя"><?php endif; ?>
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= name_profile($user_profile['name']); ?></span>
                        <time class="profile__user-time user__time" datetime="<?= date_for_user($user_profile['create_time']); ?>"><?= user_date_registration($user_profile['create_time']);?></time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <span class="user__rating-amount"><?= get_count_public($connection, $user_profile['id']);?></span>
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= get_count_subscriptions($connection, $user_profile['id']);?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <div class="profile__user-buttons user__buttons">
                    <button class="profile__user-button user__button user__button--subscription button button--main" type="button">Подписаться</button>
                    <a class="profile__user-button user__button user__button--writing button button--green" href="message.php">Сообщение</a>
                </div>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button filters__button--active tabs__item tabs__item--active button" href="profile.php?tab=posts">Посты</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="profile.php?tab=likes">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="profile.php?tab=subscription">Подписки</a>
                        </li>
                    </ul>
                </div>
                <div class="profile__tab-content">

                    <section class="profile__posts tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Публикации</h2>
                        <?php foreach ($posts as $post): ?>

                        <?php if ($post['type'] === 'post-photo'): ?>
                        <article class="profile__post post post-photo">
                            <header class="post__header">
                                <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title']; ?></a></h2>
                            </header>
                            <div class="post__main">
                                <div class="post-photo__image-wrapper">
                                    <img src="<?= $post['image']; ?>" alt="Фото от пользователя" width="760" height="396">
                                </div>
                            </div>
                           <?php require "templates/profile_footer_posts.php"; ?>
                            <?php require 'templates/profile_comments_block.php'; ?>
                        </article>

                        <?php elseif ($post['type'] === 'post-video'): ?>
                            <article class="profile__post post post-video">
                                <header class="post__header">
                                    <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title']; ?></a></h2>
                                </header>
                                <div class="post__main">
                                    <div class="post-video__block">
                                        <div class="post-video__preview">
                                            <img src="//img.youtube.com/vi/<?= extract_youtube_id($post['video']); ?>/1.jpg" alt="Превью к видео" width="760" height="396">
                                        </div>
                                        <div class="post-video__control">
                                            <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                                            <div class="post-video__scale-wrapper">
                                                <div class="post-video__scale">
                                                    <div class="post-video__bar">
                                                        <div class="post-video__toggle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                                        </div>
                                        <button class="post-video__play-big button" type="button">
                                            <svg class="post-video__play-big-icon" width="27" height="28">
                                                <use xlink:href="#icon-video-play-big"></use>
                                            </svg>
                                            <span class="visually-hidden">Запустить проигрыватель</span>
                                        </button>

                                    </div>
                                </div>
                                <?php require "templates/profile_footer_posts.php"; ?>
                                <?php require 'templates/profile_comments_block.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-text'): ?>
                            <article class="profile__post post post-text">
                                <p>
                                </p>
                                <header class="post__header">
                                    <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title']; ?></a></h2>
                                </header>
                                <div class="post__main">
                                    <p>
                                        <?= clips_text($post['message'], $post['id']);?>
                                    </p>
                                </div>
                                <?php require "templates/profile_footer_posts.php"; ?>
                                <?php require 'templates/profile_comments_block.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-quote'): ?>
                            <article class="profile__post post post-quote">
                                <header class="post__header">
                                    <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title']; ?></a></h2>
                                </header>
                                <div class="post__main">
                                    <blockquote>
                                        <p>
                                            <?= $post['message'];?>
                                        </p>
                                        <cite><?= $post['quote_writer'];?></cite>
                                    </blockquote>
                                </div>
                                <?php require "templates/profile_footer_posts.php"; ?>
                                <?php require 'templates/profile_comments_block.php'; ?>
                            </article>


                        <?php elseif ($post['type'] === 'post-link'): ?>
                            <article class="profile__post post post-link">
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
                                <?php require "templates/profile_footer_posts.php"; ?>
                                <?php require 'templates/profile_comments_block.php'; ?>
                            </article>

                        <?php endif;?>
                        <?php endforeach; ?>
                    </section>

                    <section class="profile__likes tabs__content">
                        <h2 class="visually-hidden">Лайки</h2>
                        <ul class="profile__likes-list">
                            <li class="post-mini post-mini--photo post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <div class="post-mini__action">
                                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                            <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 минут назад</time>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-mini__preview">
                                    <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                        <div class="post-mini__image-wrapper">
                                            <img class="post-mini__image" src="img/rock-small.png" width="109" height="109" alt="Превью публикации">
                                        </div>
                                        <span class="visually-hidden">Фото</span>
                                    </a>
                                </div>
                            </li>
                            <li class="post-mini post-mini--text post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <div class="post-mini__action">
                                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                            <time class="post-mini__time user__additional" datetime="2014-03-20T20:05">15 минут назад</time>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-mini__preview">
                                    <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                        <span class="visually-hidden">Текст</span>
                                        <svg class="post-mini__preview-icon" width="20" height="21">
                                            <use xlink:href="#icon-filter-text"></use>
                                        </svg>
                                    </a>
                                </div>
                            </li>
                            <li class="post-mini post-mini--video post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <div class="post-mini__action">
                                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                            <time class="post-mini__time user__additional" datetime="2014-03-20T18:20">2 часа назад</time>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-mini__preview">
                                    <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                        <div class="post-mini__image-wrapper">
                                            <img class="post-mini__image" src="img/coast-small.png" width="109" height="109" alt="Превью публикации">
                                            <span class="post-mini__play-big">
                            <svg class="post-mini__play-big-icon" width="12" height="13">
                              <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                          </span>
                                        </div>
                                        <span class="visually-hidden">Видео</span>
                                    </a>
                                </div>
                            </li>
                            <li class="post-mini post-mini--quote post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <div class="post-mini__action">
                                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                            <time class="post-mini__time user__additional" datetime="2014-03-15T20:05">5 дней назад</time>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-mini__preview">
                                    <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                        <span class="visually-hidden">Цитата</span>
                                        <svg class="post-mini__preview-icon" width="21" height="20">
                                            <use xlink:href="#icon-filter-quote"></use>
                                        </svg>
                                    </a>
                                </div>
                            </li>
                            <li class="post-mini post-mini--link post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <div class="post-mini__action">
                                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                            <time class="post-mini__time user__additional" datetime="2014-03-20T20:05">в далеком 2007-ом</time>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-mini__preview">
                                    <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                        <span class="visually-hidden">Ссылка</span>
                                        <svg class="post-mini__preview-icon" width="21" height="18">
                                            <use xlink:href="#icon-filter-link"></use>
                                        </svg>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <section class="profile__subscriptions tabs__content">
                        <h2 class="visually-hidden">Подписки</h2>
                        <ul class="profile__subscriptions-list">
                            <li class="post-mini post-mini--photo post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на сайте</time>
                                    </div>
                                </div>
                                <div class="post-mini__rating user__rating">
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                        <span class="post-mini__rating-amount user__rating-amount">556</span>
                                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                    </p>
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                        <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                    </p>
                                </div>
                                <div class="post-mini__user-buttons user__buttons">
                                    <button class="post-mini__user-button user__button user__button--subscription button button--main" type="button">Подписаться</button>
                                </div>
                            </li>
                            <li class="post-mini post-mini--photo post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на сайте</time>
                                    </div>
                                </div>
                                <div class="post-mini__rating user__rating">
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                        <span class="post-mini__rating-amount user__rating-amount">556</span>
                                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                    </p>
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                        <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                    </p>
                                </div>
                                <div class="post-mini__user-buttons user__buttons">
                                    <button class="post-mini__user-button user__button user__button--subscription button button--quartz" type="button">Отписаться</button>
                                </div>
                            </li>
                            <li class="post-mini post-mini--photo post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на сайте</time>
                                    </div>
                                </div>
                                <div class="post-mini__rating user__rating">
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                        <span class="post-mini__rating-amount user__rating-amount">556</span>
                                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                    </p>
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                        <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                    </p>
                                </div>
                                <div class="post-mini__user-buttons user__buttons">
                                    <button class="post-mini__user-button user__button user__button--subscription button button--main" type="button">Подписаться</button>
                                </div>
                            </li>
                            <li class="post-mini post-mini--photo post user">
                                <div class="post-mini__user-info user__info">
                                    <div class="post-mini__avatar user__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="post-mini__name-wrapper user__name-wrapper">
                                        <a class="post-mini__name user__name" href="#">
                                            <span>Петр Демин</span>
                                        </a>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на сайте</time>
                                    </div>
                                </div>
                                <div class="post-mini__rating user__rating">
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                        <span class="post-mini__rating-amount user__rating-amount">556</span>
                                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                    </p>
                                    <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                        <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                    </p>
                                </div>
                                <div class="post-mini__user-buttons user__buttons">
                                    <button class="post-mini__user-button user__button user__button--subscription button button--main" type="button">Подписаться</button>
                                </div>
                            </li>
                        </ul>
                    </section>

                </div>
            </div>
        </div>
    </div>
</main>