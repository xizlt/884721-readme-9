<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <?php if ($user_profile['avatar']): ?><img class="profile__picture user__picture"
                                                                   src="<?= $user_profile['avatar']; ?>"
                                                                   alt="Аватар пользователя"><?php endif; ?>
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= name_profile($user_profile['name']); ?></span>
                        <time class="profile__user-time user__time"
                              datetime="<?= date_for_user($user_profile['create_time']); ?>"><?= user_date_registration($user_profile['create_time']); ?></time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <span class="user__rating-amount"><?= get_count_public($connection,
                                $user_profile['id']); ?></span>
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= get_count_subscriptions($connection,
                                $user_profile['id']); ?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>

                <div class="profile__user-buttons user__buttons">
                    <?php if ($user['id'] !== $user_profile['id']): ?>
                        <?php if (empty($subscription_check)): ?>
                            <a href="add_sub.php?id=<?= $user_profile['id']; ?>&subscription=true" id="true">
                                <button class="profile__user-button user__button user__button--subscription button button--main"
                                        style="width: 100%; margin-bottom: 10px;" type="button">Подписаться
                                </button>
                            </a>
                        <?php else: ?>
                            <a href="add_sub.php?subscription=false&id=<?= $user_profile['id']; ?>" id="false">
                                <button class="profile__user-button user__button user__button--subscription button button--main"
                                        style="width: 100%; margin-bottom: 10px;" type="button">Отписаться
                                </button>
                            </a>
                            <a class="profile__user-button user__button user__button--writing button button--green"
                               href="message.php?tab=<?= $user_profile['id']; ?>">Сообщение</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button filters__button<?php if ($profile_block === 'posts'): ?>--active tabs__item--active<?php endif; ?>"
                               href="profile.php?id=<?= $user_profile['id']; ?>&tab=posts">Посты</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link tabs__item button filters__button<?php if ($profile_block === 'likes'): ?>--active tabs__item--active<?php endif; ?>"
                               href="profile.php?id=<?= $user_profile['id']; ?>&tab=likes">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link tabs__item button filters__button<?php if ($profile_block === 'subscription'): ?>--active tabs__item--active<?php endif; ?>"
                               href="profile.php?id=<?= $user_profile['id']; ?>&tab=subscription">Подписки</a>
                        </li>
                    </ul>
                </div>
                <div class="profile__tab-content">

                    <section
                            class="profile__posts tabs__content <?php if ($profile_block === 'posts'): ?>tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Публикации</h2>
                        <?php if (!$posts): ?>
                            <div class="feed__main-wrapper">
                                <div class="feed__wrapper">

                                </div>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($posts as $post): ?>

                            <?php if ($post['type'] === 'post-photo'): ?>
                                <article class="profile__post post post-photo">
                                    <?php if (empty($post['repost_doner_id'])): ?>
                                        <header class="post__header">
                                            <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
                                            </h2>
                                        </header>
                                    <?php else: ?>
                                        <?php require 'templates/repost.php'; ?>
                                    <?php endif; ?>
                                    <div class="post__main">
                                        <div class="post-photo__image-wrapper">
                                            <img src="<?= $post['image']; ?>" alt="Фото от пользователя" width="760"
                                                 height="396">
                                        </div>
                                    </div>
                                    <?php require "templates/profile_footer_posts.php"; ?>
                                    <?php require 'templates/profile_comments_block.php'; ?>
                                </article>

                            <?php elseif ($post['type'] === 'post-video'): ?>
                                <article class="profile__post post post-video">
                                    <?php if (empty($post['repost_doner_id'])): ?>
                                        <header class="post__header">
                                            <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
                                            </h2>
                                        </header>
                                    <?php else: ?>
                                        <?php require 'templates/repost.php'; ?>
                                    <?php endif; ?>
                                    <div class="post__main">
                                        <div class="post-video__block">
                                            <div class="post-video__preview">
                                                <?= embed_youtube_video($post['video']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php require "templates/profile_footer_posts.php"; ?>
                                    <?php require 'templates/profile_comments_block.php'; ?>
                                </article>

                            <?php elseif ($post['type'] === 'post-text'): ?>
                                <article class="profile__post post post-text">
                                    <p>
                                    </p>
                                    <?php if (empty($post['repost_doner_id'])): ?>
                                        <header class="post__header">
                                            <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
                                            </h2>
                                        </header>
                                    <?php else: ?>
                                        <?php require 'templates/repost.php'; ?>
                                    <?php endif; ?>
                                    <div class="post__main">
                                        <p>
                                            <?= clips_text($post['message'], $post['id']); ?>
                                        </p>
                                    </div>
                                    <?php require "templates/profile_footer_posts.php"; ?>
                                    <?php require 'templates/profile_comments_block.php'; ?>
                                </article>

                            <?php elseif ($post['type'] === 'post-quote'): ?>
                                <article class="profile__post post post-quote">
                                    <?php if (empty($post['repost_doner_id'])): ?>
                                        <header class="post__header">
                                            <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
                                            </h2>
                                        </header>
                                    <?php else: ?>
                                        <?php require 'templates/repost.php'; ?>
                                    <?php endif; ?>
                                    <div class="post__main">
                                        <blockquote>
                                            <p>
                                                <?= $post['message']; ?>
                                            </p>
                                            <cite><?= $post['quote_writer']; ?></cite>
                                        </blockquote>
                                    </div>
                                    <?php require "templates/profile_footer_posts.php"; ?>
                                    <?php require 'templates/profile_comments_block.php'; ?>
                                </article>


                            <?php elseif ($post['type'] === 'post-link'): ?>
                                <?php if (!empty($post['repost_doner_id'])): ?>
                                    <?php require 'templates/repost.php'; ?>
                                <?php endif; ?>
                                <article class="profile__post post">
                                    <div class="post__main">
                                        <div class="post-link__wrapper">
                                            <a class="post-link__external" href="<?= $post['link']; ?>"
                                               title="Перейти по ссылке">
                                                <div class="post-link__icon-wrapper">
                                                    <img src="img/logo-vita.jpg" alt="Иконка">
                                                </div>
                                                <div class="post-link__info">
                                                    <h3><?= $post['title']; ?></h3>
                                                    <p><?= $post['message']; ?></p>
                                                    <span><?= $post['link']; ?></span>
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

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </section>

                    <section
                            class="profile__likes tabs__content <?php if ($profile_block === 'likes'): ?>tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Лайки</h2>
                        <ul class="profile__likes-list">

                            <?php foreach ($likes as $like): ?>
                                <?php if (!$likes): ?>
                                    <div class="feed__main-wrapper">
                                        <div class="feed__wrapper">

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($like['type'] === 'post-photo'): ?>
                                    <li class="post-mini post-mini--photo post user">
                                        <div class="post-mini__user-info user__info">
                                            <?php require "templates/profile_likes_tab_post.php"; ?>
                                        </div>
                                        <div class="post-mini__preview">
                                            <a class="post-mini__link" href="post.php?id=<?= $like['id']; ?>"
                                               title="Перейти на публикацию">
                                                <div class="post-mini__image-wrapper">
                                                    <img class="post-mini__image" src="<?= $like['image']; ?>"
                                                         width="109" height="109" alt="Превью публикации">
                                                </div>
                                                <span class="visually-hidden">Фото</span>
                                            </a>
                                        </div>
                                    </li>

                                <?php elseif ($like['type'] === 'post-text'): ?>
                                    <li class="post-mini post-mini--text post user">
                                        <div class="post-mini__user-info user__info">
                                            <?php require "templates/profile_likes_tab_post.php"; ?>
                                        </div>
                                        <div class="post-mini__preview">
                                            <a class="post-mini__link" href="post.php?id=<?= $like['id']; ?>"
                                               title="Перейти на публикацию">
                                                <span class="visually-hidden">Текст</span>
                                                <svg class="post-mini__preview-icon" width="20" height="21">
                                                    <use xlink:href="#icon-filter-text"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </li>

                                <?php elseif ($like['type'] === 'post-video'): ?>
                                    <li class="post-mini post-mini--video post user">
                                        <div class="post-mini__user-info user__info">
                                            <?php require "templates/profile_likes_tab_post.php"; ?>
                                        </div>
                                        <div class="post-mini__preview">
                                            <a class="post-mini__link" href="post.php?id=<?= $like['id']; ?>"
                                               title="Перейти на публикацию">
                                                <div class="post-mini__image-wrapper">
                                                    <img class="post-mini__image"
                                                         src="//img.youtube.com/vi/<?= extract_youtube_id($like['video']); ?>/0.jpg"
                                                         width="109" height="109" alt="Превью публикации">
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

                                <?php elseif ($like['type'] === 'post-quote'): ?>
                                    <li class="post-mini post-mini--quote post user">
                                        <div class="post-mini__user-info user__info">
                                            <?php require "templates/profile_likes_tab_post.php"; ?>
                                        </div>
                                        <div class="post-mini__preview">
                                            <a class="post-mini__link" href="post.php?id=<?= $like['id']; ?>"
                                               title="Перейти на публикацию">
                                                <span class="visually-hidden">Цитата</span>
                                                <svg class="post-mini__preview-icon" width="21" height="20">
                                                    <use xlink:href="#icon-filter-quote"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </li>

                                <?php elseif ($like['type'] === 'post-link'): ?>
                                    <li class="post-mini post-mini--link post user">
                                        <div class="post-mini__user-info user__info">
                                            <?php require "templates/profile_likes_tab_post.php"; ?>
                                        </div>
                                        <div class="post-mini__preview">
                                            <a class="post-mini__link" href="post.php?id=<?= $like['id']; ?>"
                                               title="Перейти на публикацию">
                                                <span class="visually-hidden">Ссылка</span>
                                                <svg class="post-mini__preview-icon" width="21" height="18">
                                                    <use xlink:href="#icon-filter-link"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </section>

                    <section
                            class="profile__subscriptions tabs__content <?php if ($profile_block === 'subscription'): ?>tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Подписки</h2>
                        <?php if (!$profiles): ?>
                            <div class="feed__main-wrapper">
                                <div class="feed__wrapper">

                                </div>
                            </div>
                        <?php endif; ?>
                        <ul class="profile__subscriptions-list">
                            <?php foreach ($profiles as $profile): ?>
                                <li class="post-mini post-mini--photo post user">
                                    <div class="post-mini__user-info user__info">
                                        <div class="post-mini__avatar user__avatar">
                                            <a class="user__avatar-link" href="profile.php?id=<?= $profile['id']; ?>">
                                                <?php if ($profile['avatar']): ?><img
                                                    class="post-mini__picture user__picture"
                                                    src="<?= $profile['avatar']; ?>"
                                                    alt="Аватар пользователя"><?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="post-mini__name-wrapper user__name-wrapper">
                                            <a class="post-mini__name user__name"
                                               href="profile.php?id=<?= $profile['id']; ?>">
                                                <span><?= $profile['name']; ?></span>
                                            </a>
                                            <time class="post-mini__time user__additional"
                                                  datetime="<?= date_for_user($profile['create_time']); ?>"><?= user_date_registration($profile['create_time']); ?></time>
                                        </div>
                                    </div>
                                    <div class="post-mini__rating user__rating">
                                        <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                            <span class="post-mini__rating-amount user__rating-amount"><?= get_count_public($connection,
                                                    $profile['id']); ?></span>
                                            <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                        </p>

                                        <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                            <span class="post-mini__rating-amount user__rating-amount"><?= get_count_subscriptions($connection,
                                                    $profile['id']); ?></span>
                                            <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                        </p>
                                    </div>
                                    <div class="post-mini__user-buttons user__buttons">
                                        <?php if ($user['id'] !== $profile['id']): ?>
                                            <?php if (!get_subscription($connection, $user['id'], $profile['id'])): ?>
                                                <a href="add_sub.php?id=<?= $profile['id']; ?>&subscription=true"
                                                   id="true">
                                                    <button class="post-mini__user-button user__button user__button--subscription button button--main"
                                                            style="width: 100%; margin-bottom: 10px;" type="button">
                                                        Подписаться
                                                    </button>
                                                </a>
                                            <?php else: ?>
                                                <a href="add_sub.php?id=<?= $profile['id']; ?>&subscription=false"
                                                   id="false">
                                                    <button class="post-mini__user-button user__button user__button--subscription button button--quartz"
                                                            type="button">Отписаться
                                                    </button>
                                                </a>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>

                </div>
            </div>
        </div>
    </div>
</main>