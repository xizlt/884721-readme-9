<div class="adding-post__input-wrapper form__input-wrapper <?= isset($errors['title'])? 'form__input-section--error' : ' ' ?>">
    <label class="adding-post__label form__label" for="title">Заголовок <span class="form__input-required">*</span></label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="title" type="text" name="title" placeholder="Введите заголовок" value="<?= isset($post_data['title'])? $post_data['title'] : ''  ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= $errors['title']['for_title']; ?></h3>
            <p class="form__error-desc"><?= $errors['title']['for_text']; ?></p>
        </div>
    </div>
</div>
