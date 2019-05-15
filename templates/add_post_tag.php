<div class="adding-post__input-wrapper form__input-wrapper <?= isset($errors['tags'])? 'form__input-section--error' : ' ' ?>">
    <label class="adding-post__label form__label" for="cite-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="cite-tags" type="text" name="tags" placeholder="Введите теги">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
        </div>
    </div>
</div>

