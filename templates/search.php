<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?= $search; ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">

                    <?php foreach ($posts as $post): ?>

                        <?php if ($post['type'] === 'post-quote'): ?>
                            <article class="search__post post post-quote">
                                <?php require 'templates/header_posts.php'; ?>
                                <div class="post__main">
                                    <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a></h2>
                                    <blockquote>
                                        <p>
                                            <?= $post['message']; ?>
                                        </p>
                                        <cite><?= $post['quote_writer']; ?></cite>
                                    </blockquote>
                                </div>
                                <?php require 'templates/footer_posts.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-photo'): ?>
                            <article class="search__post post post-photo">
                                <?php require 'templates/header_posts.php'; ?>

                                <div class="post__main">
                                    <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a></h2>
                                    <div class="post-photo__image-wrapper">
                                        <img src="img/rock.jpg" alt="Фото от пользователя" width="760" height="396">
                                    </div>
                                </div>
                                <?php require 'templates/footer_posts.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-text'): ?>
                            <article class="search__post post post-text">
                                <?php require 'templates/header_posts.php'; ?>
                                <div class="post__main">
                                    <h2><a href="post.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a></h2>
                                    <p>
                                        <?= clips_text($post['message'], $post['id']); ?>
                                    </p>
                                </div>
                                <?php require 'templates/footer_posts.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-video'): ?>
                            <article class="search__post post post-video">
                                <?php require 'templates/header_posts.php'; ?>
                                <div class="post__main">
                                    <div class="post-video__block">
                                        <?= embed_youtube_video($post['video']); ?>

                                    </div>
                                </div>
                                <?php require 'templates/footer_posts.php'; ?>
                            </article>

                        <?php elseif ($post['type'] === 'post-link'): ?>
                            <article class="search__post post post-link">
                                <?php require 'templates/header_posts.php'; ?>
                                <div class="post__main">
                                    <div class="post-link__wrapper">
                                        <a class="post-link__external" href="<?= $post['link'] ?>"
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
                                <?php require 'templates/footer_posts.php'; ?>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>
</main>
