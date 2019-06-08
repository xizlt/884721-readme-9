<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <div class="messages__contacts">
            <ul class="messages__contacts-list tabs__list">

                <?php foreach ($users_messages as $user_message): ?>
                    <?php  if ($user_message['sender_id'] !== $user['id']): ?>
                        <li class="messages__contacts-item messages__contacts-item--new">
                    <a class="messages__contacts-tab tabs__item" href="message.php?tab=<?= $user_message['sender_id'];?>">
                        <div class="messages__avatar-wrapper">
                            <?php if ($user_message['avatar']): ?> <img class="messages__avatar" src="<?= $user_message['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
                            <i class="messages__indicator"><?=$count_message; ?></i>
                        </div>
                        <div class="messages__info">
                              <span class="messages__contact-name">
                                <?=$user_message['name'];?>
                              </span>
                            <div class="messages__preview">
                                <p class="messages__preview-text">
                                    <?=clips_text_message($user_message['message']);?>
                                </p>
                                <time class="messages__preview-time" datetime="<?=$user_message['create_date']; ?>">
                                    <?= publication_date($user_message['create_date']); ?>
                                </time>
                            </div>
                        </div>
                    </a>
                </li>
                <?php elseif($user_message['sender_id'] === $user['id']): ?>
                        <?php $user_ids = get_user_by_id($connection, $user_message['recipient_id']);?>
                        <li class="messages__contacts-item messages__contacts-item--new">
                            <a class="messages__contacts-tab tabs__item" href="message.php?tab=<?= $user_message['recipient_id'];?>">
                                <div class="messages__avatar-wrapper">
                                    <?php if ($user_ids['avatar']): ?> <img class="messages__avatar" src="<?= $user_ids['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
                                    <i class="messages__indicator"><?=$count_message; ?></i>
                                </div>
                                <div class="messages__info">
                              <span class="messages__contact-name">
                                <?=$user_ids['name'];?>
                              </span>
                                    <div class="messages__preview">
                                        <p class="messages__preview-text">
                                            Вы <?=clips_text_message($user_message['message']);?>
                                        </p>
                                        <time class="messages__preview-time" datetime="<?=$user_message['create_date']; ?>">
                                            <?= publication_date($user_message['create_date']); ?>
                                        </time>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endif;?>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="messages__chat">
            <div class="messages__chat-wrapper">


                <ul class="messages__list tabs__content tabs__content--active">

                    <?php foreach ($messages as $message): ?>
                        <?php if( $message['sender_id'] ===  $user_id_ind and $message['recipient_id'] === $user['id']): ?>
                        <li class="messages__item">
                        <div class="messages__info-wrapper">
                            <div class="messages__item-avatar">
                                <a class="messages__author-link" href="profile.php?id=<?=$message['id'];?>">
                                   <?php if ($message['avatar']): ?> <img class="messages__avatar" src="<?= $message['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
                                </a>
                            </div>
                            <div class="messages__item-info">
                                <a class="messages__author" href="profile.php?id=<?=$message['id'];?>">
                                    <?= $message['name'];?>
                                </a>
                                <time class="messages__time" datetime="<?= date_for_title($message['create_date']); ?>">
                                    <?= publication_date($message['create_date']); ?>
                                </time>
                            </div>
                        </div>
                        <p class="messages__text">
                            <?=$message['message'];?>
                        </p>
                    </li>
                        <?php elseif( $message['sender_id'] === $user['id']  and $message['recipient_id'] ===  $user_id_ind): ?>
                        <li class="messages__item messages__item--my">
                            <div class="messages__info-wrapper">
                                <div class="messages__item-avatar">
                                    <a class="messages__author-link" href="profile.php?id=<?=$message['id'];?>">
                                        <?php if ($message['avatar']): ?> <img class="messages__avatar" src="<?= $message['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
                                    </a>
                                </div>
                                <div class="messages__item-info">
                                    <a class="messages__author" href="profile.php?id=<?=$message['id'];?>">
                                        <?= $message['name'];?>
                                    </a>
                                    <time class="messages__time" datetime="<?= date_for_title($message['create_date']); ?>">
                                        <?= publication_date($message['create_date']); ?>
                                    </time>
                                </div>
                            </div>
                            <p class="messages__text">
                                <?=$message['message'];?>
                            </p>
                        </li>
                    <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="comments">
                <form class="comments__form form" action="message.php?tab=<?=$user_id_ind;?>" method="post">
                    <div class="comments__my-avatar">
                        <?php if ($user['avatar']): ?> <img class="comments__picture" src="<?= $user['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
                    </div>
                    <div class="form__input-section <?= !empty($error)? ' form__input-section--error' : ' ' ?>">
                    <textarea class="comments__textarea form__textarea" placeholder="Ваше сообщение" name="message"></textarea>
                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <p class="form__error-desc"><?= $error; ?></p>
                    </div>
                    <label class="visually-hidden">Ваше сообщение</label>
                    </div>
                    <button class="comments__submit button button--green" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </section>
</main>


