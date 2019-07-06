<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <div class="messages__contacts">
            <ul class="messages__contacts-list tabs__list">
                <?php foreach ($dialogs as $dialog): ?>
                <?php if ($dialog !== $user['id']): ?>
                <?php $message = get_message($connection, $user['id'], $dialog);?>
                <?php $user_info = get_user_by_id($connection, $dialog);?>
                <?php if($user_info):?>
                <li class="messages__contacts-item">
                            <a class="messages__contacts-tab tabs__item tabs__item--active <?php if($dialog === $user_dialog): ?>messages__contacts-tab--active<?php endif;?>" href="message.php?u=<?= $dialog;?>">
                                <div class="messages__avatar-wrapper">
                                    <img class="messages__avatar" src="<?= $user_info['avatar'];?>" alt="Аватар пользователя">
                                    <?php $is_read = get_count_new_message($connection, $user['id'], $user_info['id']);?>
                                    <?php if ($is_read !== 0):?>
                                        <i class="messages__indicator"><?= $is_read;?></i>
                                    <?php endif;?>
                                </div>
                                <div class="messages__info">
                                    <span class="messages__contact-name">
                      <?= $user_info['name'];?>
                  </span>
                            <div class="messages__preview">
                                <p class="messages__preview-text">
                                    <?php if ($message['sender_id'] === $user['id']): ?>
                                    Вы:
                                    <?php endif;?>
                                    <?= clips_text_message($message['message']);?>
                                </p>
                                <time class="messages__preview-time" datetime="<?= date_for_title($message['create_date']);?>">
                                    <?= message_date($message['create_date']);?>
                                </time>
                            </div>
                        </div>
                    </a>
                </li>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>

        </div>

        <?php $user_info = get_user_by_id($connection, $user_dialog) ?? null;?>
        <?php if($dialogs OR $user_info):?>
            <div class="messages__chat">
            <div class="messages__chat-wrapper">
                <?php $texts = get_messages_for_dialog($connection, $user['id'], $user_dialog);?>
                <?php foreach ($texts as $text): ?>
                <ul class="messages__list tabs__content tabs__content--active">
                        <?php if($text['sender_id'] !== $user['id']): ?>
                            <li class="messages__item">
                        <div class="messages__info-wrapper">
                            <div class="messages__item-avatar">
                                <a class="messages__author-link" href="profile.php?id=<?=$user_info['id']; ?>">
                                    <img class="messages__avatar" src="<?=$user_info['avatar']; ?>" alt="Аватар пользователя">
                                </a>
                            </div>
                            <div class="messages__item-info">
                                <a class="messages__author" href="profile.php?id=<?=$user_info['id']; ?>">
                                    <?=$user_info['name']; ?>
                                </a>
                                <time class="messages__time" datetime="<?= date_for_title($text['create_date']);?>">
                                    <?= message_date($text['create_date']);?>
                                </time>
                            </div>
                        </div>
                        <p class="messages__text">
                            <?=$text['message'];?>
                        </p>
                    </li>
                        <?php else:?>
                            <li class="messages__item messages__item--my">
                        <div class="messages__info-wrapper">
                            <div class="messages__item-avatar">
                                <a class="messages__author-link" href="profile.php?id=<?=$user['id'];?>">
                                    <img class="messages__avatar" src="<?=$user['avatar'];?>" alt="Аватар пользователя">
                                </a>
                            </div>
                            <div class="messages__item-info">
                                <a class="messages__author" href="profile.php?id=<?=$user['id']; ?>">
                                    <?=$user['name']; ?>
                                </a>
                                <time class="messages__time" datetime="<?= date_for_title($text['create_date']);?>">
                                    <?= message_date($text['create_date']);?>
                                </time>
                            </div>
                        </div>
                        <p class="messages__text">
                            <?=$text['message'];?>
                        </p>
                    </li>
                        <?php endif;?>
                </ul>
                <?php endforeach;?>
            </div>
            <div class="comments">
                <form class="comments__form form" action="message.php?u=<?= $user_info['id'];?>&si=<?= $user['id'];?>" method="post">
                    <div class="comments__my-avatar">
                        <?php if ($user['avatar']): ?>
                        <img class="comments__picture" src="<?= $user['avatar'];?>" alt="Аватар пользователя">
                        <?php endif;?>
                    </div>
                    <textarea class="comments__textarea form__textarea" placeholder="Ваше сообщение" name="text"></textarea>
                        <div class="form__input-section <?= !empty($error) ? ' form__input-section--error' : ' ' ?>">
                            <button class="form__error-button button" type="button">!
                            <span class="visually-hidden">Информация об ошибке</span>
                            </button>
                        <div class="form__error-text">
                            <p class="form__error-desc"><?= $error; ?></p>
                        </div>
                        </div>
                    <label class="visually-hidden">Ваше сообщение</label>
                    <button class="comments__submit button button--green" type="submit">Отправить</button>
                </form>
            </div>
        </div>
        <?php endif;?>

    </section>
    <?php if (!$dialogs):?>
        <div class="feed__main-wrapper">
            <div class="feed__wrapper">
            </div>
        </div>
    <?php endif;?>
</main>

