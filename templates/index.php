<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="<?php if ($type_block): ?>/?type_id=<?= $type_block; ?>&tab=likes<?php else: ?>/?tab=likes<?php endif;?>">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="<?php if ($type_block): ?>/?type_id=<?= $type_block; ?>&tab=likes<?php else: ?>/?tab=likes<?php endif; ?>">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="<?php if ($type_block): ?>/?type_id=<?= $type_block; ?>&tab=date<?php else: ?>/?tab=date<?php endif; ?>">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?php if(empty($type_block)): ?> filters__button--active <?php endif;?>" href="/">
                            <span>Все</span>
                        </a>
                    </li>

                    <?php foreach ($types as $type): ?>
                    <?php if ($type['name'] === 'post-photo'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--photo button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="index.php?type_id=<?= $type['id']; ?>">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-photo"></use>
                            </svg>
                        </a>
                    </li>

                    <?php elseif ($type['name'] === 'post-video'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--video button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="index.php?type_id=<?= $type['id']; ?>">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="#icon-filter-video"></use>
                            </svg>
                        </a>
                    </li>

                    <?php elseif ($type['name'] === 'post-text'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--text button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="index.php?type_id=<?= $type['id']; ?>">
                            <span class="visually-hidden">Текст</span>
                            <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                            </svg>
                        </a>
                    </li>

                    <?php elseif ($type['name'] === 'post-quote'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--quote button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="index.php?type_id=<?= $type['id']; ?>">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                            </svg>
                        </a>
                    </li>

                    <?php elseif ($type['name'] === 'post-link'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--link button <?php if($types_correct['id'] === $type['id']):?> filters__button--active <?php endif;?>" href="index.php?type_id=<?= $type['id']; ?>">
                            <span class="visually-hidden">Ссылка</span>
                            <svg class="filters__icon" width="21" height="18">
                                <use xlink:href="#icon-filter-link"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>

        <div class="popular__posts">
            <?php foreach ($posts as $post): ?>
                <article class="popular__post post <?= clean($post['type']); ?>">
                    <header class="post__header">
                        <h2><a href="post.php?id=<?= $post['id']; ?>" title="<?= clean($post['title']); ?>"><?= clean($post['title']); ?></a></h2>
                    </header>
                    <div class="post__main">
                        <?php if (clean($post['type'])==='post-quote'): ?>
                            <!--содержимое для поста-цитаты-->
                            <blockquote>
                                <p>
                                    <?= clips_text(clean($post['message'])); ?>
                                </p>
                                <cite><?= (!$post['quote_writer'])? 'Неизвестный Автор' : $post['quote_writer']; ?></cite>
                            </blockquote>

                        <?php elseif (clean($post['type'])==='post-link'): ?>
                            <!--содержимое для поста-ссылки-->
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://<?= clean($post['link']); ?>" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="img/logo-vita.jpg" alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= clean($post['title']); ?></h3>
                                        </div>
                                    </div>
                                    <span><?= clean($post['link']); ?></span>
                                </a>
                            </div>

                        <?php elseif (clean($post['type'])==='post-photo'): ?>
                            <!--содержимое для поста-фото-->
                            <div class="post-photo__image-wrapper">
                                <img src="<?= clean($post['image']); ?>" alt="Фото от пользователя" width="360" height="240">
                            </div>

                        <?php elseif (clean($post['type'])==='post-text'): ?>
                            <!--содержимое для поста-текста-->
                            <p><?= clips_text(clean($post['message'])); ?></p>
                        <?php endif; ?>

                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="<?= clean($post['avatar']); ?>" alt="Аватар пользователя">
                                </div>
                                    <?php $generate_index_array = clean($post['create_time']); ?>
                                <div class="post__info">
                                    <b class="post__author-name"><?= clean($post['user_name']); ?></b>
                                    <time class="post__time" datetime="<?= $generate_index_array; ?>" title="<?= date_for_title($generate_index_array) ?>"><?= publication_date($generate_index_array); ?></time>
                                </div>

                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?= $post['like_post']; ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?= (get_count_comments($connection, $post['id'])) ?? '0';?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>