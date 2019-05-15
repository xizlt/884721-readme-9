<div class="adding-post__input-wrapper form__input-wrapper <?= isset($errors['tags'])? 'form__input-section--error' : ' ' ?>">
    <label class="adding-post__label form__label" for="cite-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="cite-tags" type="text" name="tags" placeholder="Введите теги">
        <?= $error_text; ?>
    </div>
</div>

