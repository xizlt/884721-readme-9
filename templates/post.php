<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= $post['title']; ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-photo">
                <div class="post-details__main-block post post--details">

                    <?= $block_post; ?>

                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button"
                               href="add_like.php?post_id=<?= $post['id']; ?>" title="Лайк">
                                <?php $like_check = get_like_by_user($connection, $post['id'], $user['id']); ?>
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart<?php if ($like_check): ?>-active<?php endif; ?>"></use>
                                </svg>
                                <span><?= $post['like_post']; ?></span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?= $comments_count; ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button"
                               href="add_repost.php?post_id=<?= $post['id']; ?>" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-repost"></use>
                                </svg>
                                <span><?= $post['repost']; ?> </span>
                                <span class="visually-hidden">количество репостов</span>
                            </a>
                        </div>
                        <span class="post__view"><?= $post['view_count']; ?></span>
                    </div>
                    <div class="comments">

                        <form class="comments__form form " action="post.php?id=<?= $post['id'] ?>&show=true"
                              method="post">
                            <div class="comments__my-avatar">
                                <?php if ($user['avatar']): ?> <img class="comments__picture"
                                                                    src="<?= $user['avatar']; ?>"
                                                                    alt="Аватар пользователя"><?php endif; ?>
                            </div>
                            <div class="form__input-section <?= !empty($error) ? ' form__input-section--error' : ' ' ?>">
                                <textarea class="comments__textarea form__textarea " placeholder="Ваш комментарий"
                                          name="comment"></textarea>
                                <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span>
                                </button>
                                <div class="form__error-text">
                                    <p class="form__error-desc"><?= $error; ?></p>
                                </div>
                                <label class="visually-hidden">Ваш комментарий</label>
                            </div>

                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                            <ul class="comments__list">
                                <?php foreach ($comments as $comment): ?>
                                    <li class="comments__item user">
                                        <div class="comments__avatar">
                                            <a class="user__avatar-link"
                                               href="profile.php?id=<?= $comment['user_id']; ?>">
                                                <?php if ($comment['avatar']): ?><img class="comments__picture"
                                                                                      src="<?= $comment['avatar']; ?>"
                                                                                      alt="Аватар пользователя"><?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="comments__info">
                                            <div class="comments__name-wrapper">
                                                <a class="comments__user-name"
                                                   href="profile.php?id=<?= $comment['user_id']; ?>">
                                                    <span><?= $comment['name']; ?></span>
                                                </a>
                                                <time class="comments__time"
                                                      datetime="<?= date_for_user($comment['time_comment']); ?>"><?= publication_date($comment['time_comment']); ?></time>
                                            </div>
                                            <p class="comments__text">
                                                <?= $comment['message']; ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($comments_count > 2): ?>
                                <?php $count_comments = get_count_comments($connection, $post['id']); ?>
                                <?php if ($count_comments > 2): ?>
                                    <a class="comments__more-link" href="post.php">
                                        <span>Показать все комментарии</span>
                                        <sup class="comments__amount"><?= $count_comments ?></sup>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="post-details__user user">
                    <div class="post-details__user-info user__info">
                        <div class="post-details__avatar user__avatar">
                            <a class="post-details__avatar-link user__avatar-link"
                               href="profile.php?id=<?= $post['user']; ?>">
                                <?php if ($post['avatar']): ?><img class="post-details__picture user__picture"
                                                                   src="<?= $post['avatar']; ?>"
                                                                   alt="Аватар пользователя" width="60"
                                                                   height="60"><?php endif; ?>
                            </a>
                        </div>
                        <div class="post-details__name-wrapper user__name-wrapper">
                            <a class="post-details__name user__name" href="profile.php?id=<?= $post['user']; ?>">
                                <span><?= $post['user_name']; ?></span>
                            </a>
                            <time class="post-details__time user__time"
                                  datetime="<?= date_for_user($post['user_reg']); ?>"><?= user_date_registration($post['user_reg']); ?></time>
                        </div>
                    </div>
                    <div class="post-details__rating user__rating">
                        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">

                            <span class="post-details__rating-amount user__rating-amount"><?= $subscriptions; ?></span>

                            <span class="post-details__rating-text user__rating-text">подписчиков</span>
                        </p>
                        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                            <span class="post-details__rating-amount user__rating-amount"><?= $public_count; ?></span>
                            <span class="post-details__rating-text user__rating-text">публикаций</span>
                        </p>
                    </div>
                    <?php if ($user['id'] !== $post['user']): ?>
                        <?php if (empty($subscription_check)): ?>
                            <a href="add_sub.php?id=<?= $post['user']; ?>&subscription=true" id="true">
                                <button class="profile__user-button user__button user__button--subscription button button--main"
                                        style="width: 100%; margin-bottom: 10px;" type="button">Подписаться
                                </button>
                            </a>
                        <?php else: ?>
                            <a href="add_sub.php?subscription=false&id=<?= $post['user']; ?>" id="false">
                                <button class="profile__user-button user__button user__button--subscription button button--main"
                                        style="width: 100%; margin-bottom: 10px;" type="button">Отписаться
                                </button>
                            </a>
                            <a class="user__button user__button--writing button button--green" href="message.php"
                               style="width: 100%; margin-bottom: 10px;">Сообщение</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>
