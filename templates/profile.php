
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
                    <?php foreach ($posts as $post): ?>

                    <section class="profile__posts tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Публикации</h2>

                        <article class="profile__post post post-photo">
                            <header class="post__header">
                                <h2><a href="post.php?id=<?= $post['id'];?>"><?= $post['title']; ?></a></h2>
                            </header>
                            <div class="post__main">
                                <div class="post-photo__image-wrapper">
                                    <img src="img/rock.jpg" alt="Фото от пользователя" width="760" height="396">
                                </div>
                            </div>
                           <?php require "templates/profile_footer_posts.php"; ?>

                            <?php require 'templates/profile_comments_block.php'; ?>

                        </article>


                        <article class="profile__post post post-text">
                            <header class="post__header">
                                <div class="post__author">
                                    <a class="post__author-link" href="#" title="Автор">
                                        <div class="post__avatar-wrapper post__avatar-wrapper--repost">
                                            <img class="post__author-avatar" src="img/userpic-tanya.jpg" alt="Аватар пользователя">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name">Репост: Таня Фирсова</b>
                                            <time class="post__time" datetime="2019-03-30T14:31">25 минут назад</time>
                                        </div>
                                    </a>
                                </div>
                            </header>
                            <div class="post__main">
                                <h2><a href="#">Полезный пост про Байкал</a></h2>
                                <p>
                                    Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
                                </p>
                                <a class="post-text__more-link" href="#">Читать далее</a>
                            </div>
                            <?php require "templates/profile_footer_posts.php"; ?>

                            <form class="comments__form form" action="#" method="post">
                                <div class="comments__my-avatar">
                                    <img class="comments__picture" src="img/userpic.jpg" alt="Аватар пользователя">
                                </div>
                                <textarea class="comments__textarea form__textarea" placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="comments__submit button button--green" type="submit">Отправить</button>
                            </form>
                        </article>
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
                    <?php endforeach; ?>
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