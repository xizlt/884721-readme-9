
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">

                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--photo <?php if($tab === 'photo'): ?> filters__button--active tabs__item tabs__item--active <?php endif; ?>button" href="add.php?tab=photo">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-photo"></use>
                                </svg>
                                <span>Фото</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--video tabs__item button <?php if($tab === 'video'): ?> filters__button--active tabs__item tabs__item--active <?php endif; ?> button" href="add.php?tab=video">
                                <svg class="filters__icon" width="24" height="16">
                                    <use xlink:href="#icon-filter-video"></use>
                                </svg>
                                <span>Видео</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--text tabs__item <?php if($tab === 'text'): ?> filters__button--active tabs__item tabs__item--active <?php endif; ?> button" href="add.php?tab=text">
                                <svg class="filters__icon" width="20" height="21">
                                    <use xlink:href="#icon-filter-text"></use>
                                </svg>
                                <span>Текст</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--quote tabs__item <?php if($tab === 'quote'): ?> filters__button--active tabs__item tabs__item--active <?php endif; ?> button" href="add.php?tab=quote">
                                <svg class="filters__icon" width="21" height="20">
                                    <use xlink:href="#icon-filter-quote"></use>
                                </svg>
                                <span>Цитата</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--link tabs__item <?php if($tab === 'link'): ?>filters__button--active tabs__item tabs__item--active <?php endif; ?>button" href="add.php?tab=link">
                                <svg class="filters__icon" width="21" height="18">
                                    <use xlink:href="#icon-filter-link"></use>
                                </svg>
                                <span>Ссылка</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="adding-post__tab-content">

                    <section class="adding-post__photo tabs__content <?php if($tab === 'photo'): ?> tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Форма добавления фото</h2>
                        <form class="adding-post__form form" action="/add.php?tab=photo" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $title_post; ?>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>

                                        <div class="form__input-section <?= isset($errors['link'])? 'form__input-section--error' : ' ' ?>">
                                            <input class="adding-post__input form__input " id="photo-url" type="text" name="link" placeholder="Введите ссылку" value="<?= isset($post_data['link'])? $post_data['link'] : ''  ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['link']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['link']['for_text']; ?></p>
                                            </div>
                                        </div>

                                    </div>
                                    <?= $tags_post; ?>
                                </div>
                                <?= $block_errors; ?>
                            </div>
                            <div class="adding-post__input-file-container form__input-container form__input-container--file ">
                                <div class="adding-post__input-file-wrapper form__input-file-wrapper ">
                                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone ">
                                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="img" title=" " value="<?= isset($file_data['img'])? $file_data['img']['tmp_name'] : ''  ?>">
                                        <div class="form__file-zone-text ">
                                            <span>Перетащите фото сюда</span>
                                        </div>
                                    </div>
                                    <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                                        <span>Выбрать фото</span>
                                        <svg class="adding-post__attach-icon form__attach-icon " width="10" height="20">
                                            <use xlink:href="#icon-attach"></use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                                </div>
                            </div>
                            <?= $send_form; ?>
                        </form>
                    </section>

                    <section class="adding-post__video tabs__content <?php if($tab === 'video'): ?> tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Форма добавления видео</h2>
                        <form class="adding-post__form form" action="/add.php?tab=video" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $title_post; ?>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['video']) ? ' form__input-section--error' : ' ' ?>">
                                            <input class="adding-post__input form__input" id="video-url" type="text" name="link" placeholder="Введите ссылку" value="<?= isset($post_data['link'])? $post_data['link'] : ''  ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['video']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['video']['for_text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $tags_post; ?>
                                </div>
                                <?= $block_errors; ?>
                            </div>
                            <?= $send_form; ?>
                        </form>
                    </section>

                    <section class="adding-post__text tabs__content <?php if($tab === 'text'): ?> tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Форма добавления текста</h2>
                        <form class="adding-post__form form" action="/add.php?tab=text" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $title_post; ?>
                                    <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                        <div class="form__input-section <?= isset($errors['message'])? 'form__input-section--error' : ' ' ?>">
                                            <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="message" placeholder="Введите текст публикации"><?= isset($post_data['message'])? $post_data['message'] : ''?></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['message']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['message']['for_text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $tags_post; ?>
                                </div>
                                <?= $block_errors; ?>
                            </div>
                            <?= $send_form; ?>
                        </form>
                    </section>

                    <section class="adding-post__quote tabs__content <?php if($tab === 'quote'): ?> tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Форма добавления цитаты</h2>
                        <form class="adding-post__form form" action="/add.php?tab=quote" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $title_post; ?>
                                    <div class="adding-post__input-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['message'])? 'form__input-section--error' : ' ' ?>">
                                            <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="message" placeholder="Текст цитаты"><?= isset($post_data['message'])? $post_data['message'] : ''?></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['message']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['message']['for_text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__textarea-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['quote'])? 'form__input-section--error' : ' ' ?>">
                                            <input class="adding-post__input form__input" id="quote-author" type="text" name="quote" value="<?= isset($post_data['quote'])? $post_data['quote'] : ''  ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['quote']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['quote']['for_text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $tags_post; ?>
                                </div>
                                <?= $block_errors; ?>
                            </div>
                            <?= $send_form; ?>
                        </form>
                    </section>

                    <section class="adding-post__link tabs__content <?php if($tab === 'link'): ?> tabs__content--active<?php endif; ?>">
                        <h2 class="visually-hidden">Форма добавления ссылки</h2>
                        <form class="adding-post__form form" action="/add.php?tab=link" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs ">
                                    <?= $title_post; ?>
                                    <div class="adding-post__textarea-wrapper form__input-wrapper ">
                                        <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['link'])? 'form__input-section--error' : ' ' ?>">
                                            <input class="adding-post__input form__input" id="post-link" type="text" name="link" value="<?= isset($post_data['link'])? $post_data['link'] : ''  ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title"><?= $errors['link']['for_title']; ?></h3>
                                                <p class="form__error-desc"><?= $errors['link']['for_text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $tags_post;?>
                                </div>
                                <?= $block_errors; ?>
                            </div>
                            <?= $send_form; ?>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>
