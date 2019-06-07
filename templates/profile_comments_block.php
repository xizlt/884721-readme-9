
<?php if ($show_comments_block === 'true'): ?>
<div class="comments">
    <div class="comments__list-wrapper">

        <?php $comments = get_comments($connection, $post['id']); ?>

        <?php foreach ($comments as $comment): ?>
        <ul class="comments__list">
            <li class="comments__item user">
                <div class="comments__avatar">
                    <a class="user__avatar-link" href="profile.php?id=<?= $comment['user_id'];?>">
                        <?php if ($comment['avatar']): ?> <img class="comments__picture" src="<?= $comment['avatar']; ?>" alt="Аватар пользователя"><?php endif; ?>
                    </a>
                </div>
                <div class="comments__info">
                    <div class="comments__name-wrapper">
                        <a class="comments__user-name" href="profile.php?id=<?= $comment['user_id'];?>">
                            <span><?= $comment['name']; ?></span>
                        </a>
                        <time class="comments__time" datetime="<?= date_for_user($comment['time_comment']); ?>"><?= publication_date($comment['time_comment']);?></time>
                    </div>
                    <p class="comments__text">
                        <?= $comment['message'];?>
                    </p>
                </div>
            </li>
        </ul>
        <?php endforeach; ?>

        <?php $count_comments = get_count_comments($connection, $post['id']);?>
        <?php if ($count_comments > 2): ?>
        <a class="comments__more-link" href="profile.php?id=<?= $user_profile['id']; ?>&show=true">
            <span>Показать все комментарии</span>
            <sup class="comments__amount"><?= $count_comments ?></sup>
        </a>
        <?php endif; ?>
    </div>
</div>


    <form class="comments__form form " action="profile.php?id=<?= $user_profile['id']; ?>&post-id=<?= $post['id']?>&show=true" method="post">
        <div class="comments__my-avatar">
            <?php if ($user['avatar']): ?> <img class="comments__picture" src="<?= $user['avatar']; ?>" alt="Аватар пользователя"><?php endif;?>
        </div>
        <div class="form__input-section <?= !empty($error)? ' form__input-section--error' : ' ' ?>">
            <textarea class="comments__textarea form__textarea " placeholder="Ваш комментарий" name="comment"></textarea>
            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
            <div class="form__error-text">
                <p class="form__error-desc"><?= $error; ?></p>
            </div>
            <label class="visually-hidden">Ваш комментарий</label>
        </div>

        <button class="comments__submit button button--green" type="submit">Отправить</button>
    </form>


<?php else: ?>
    <div class="comments">
        <a class="comments__button button" href="profile.php?id=<?= $user_profile['id']; ?>&show=true">Показать комментарии</a>
    </div>
<?php endif; ?>
