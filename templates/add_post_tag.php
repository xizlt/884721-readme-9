<div class="adding-post__input-wrapper form__input-wrapper <?= isset($errors['tags']) ? 'form__input-section--error' : ' ' ?>">
    <label class="adding-post__label form__label" for="cite-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="cite-tags" type="text" name="tags" placeholder="Введите теги"
               value="<?= isset($post_data['tags']) ? $post_data['tags'] : '' ?>">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= $errors['tags']['for_title']; ?></h3>
            <p class="form__error-desc"><?= $errors['tags']['for_text']; ?></p>
        </div>
    </div>
</div>

