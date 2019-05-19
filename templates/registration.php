<main class="page__main page__main--registration">
    <div class="container">
        <h1 class="page__title page__title--registration">Регистрация</h1>
    </div>
    <section class="registration container">
        <h2 class="visually-hidden">Форма регистрации</h2>
        <form class="registration__form form" action="#" method="post" enctype="multipart/form-data">
            <div class="form__text-inputs-wrapper">
                <div class="form__text-inputs">
                    <div class="registration__input-wrapper form__input-wrapper">
                        <label class="registration__label form__label" for="registration-email">Электронная почта<span class="form__input-required">*</span></label>
                        <div class="form__input-section form__input-section--error">
                            <input class="registration__input form__input" id="registration-email" type="email" name="email" placeholder="Укажите эл.почту">
                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                            </div>
                        </div>
                    </div>
                    <div class="registration__input-wrapper form__input-wrapper">
                        <label class="registration__label form__label" for="registration-password">Пароль<span class="form__input-required">*</span></label>
                        <div class="form__input-section form__input-section--error">
                            <input class="registration__input form__input" id="registration-password" type="password" name="password" placeholder="Придумайте пароль">
                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                            </div>
                        </div>
                    </div>
                    <div class="registration__input-wrapper form__input-wrapper">
                        <label class="registration__label form__label" for="registration-password-repeat">Повтор пароля<span class="form__input-required">*</span></label>
                        <div class="form__input-section form__input-section--error">
                            <input class="registration__input form__input" id="registration-password-repeat" type="password" name="password-repeat" placeholder="Повторите пароль">
                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                            </div>
                        </div>
                    </div>
                    <div class="registration__textarea-wrapper form__textarea-wrapper">
                        <label class="registration__label form__label" for="text-info">Информация о себе</label>
                        <div class="form__input-section form__input-section--error">
                            <textarea class="registration__textarea form__textarea form__input" id="text-info" placeholder="Коротко о себе в свободной форме"></textarea>
                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__invalid-block">
                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                    <ul class="form__invalid-list">
                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                        <li class="form__invalid-item">Цитата. Она не должна превышать 70 знаков.</li>
                    </ul>
                </div>
            </div>
            <div class="registration__input-file-container form__input-container form__input-container--file">
                <div class="registration__input-file-wrapper form__input-file-wrapper">
                    <div class="registration__file-zone form__file-zone" for="userpic-file">
                        <input class="registration__input-file form__input-file" id="userpic-file" type="file" name="userpic-file">
                        <div class="form__file-zone-text">
                            <span>Перетащите фото сюда</span>
                        </div>
                    </div>
                    <label class="registration__input-file-button form__input-file-button" for="userpic-file">
                        <span>Выбрать фото</span>
                        <svg class="registration__attach-icon form__attach-icon" width="10" height="20">
                            <use xlink:href="#icon-attach"></use>
                        </svg>
                    </label>
                </div>
                <div class="registration__file form__file">
                    <div class="registration__image-wrapper form__file-wrapper">
                        <img class="form__image" src="img/userpic-big.jpg" alt="Загруженный файл">
                    </div>
                    <div class="registration__file-data form__file-data">
                        <span class="registration__file-name form__file-name" title="dsc001.jpg">dsc001.jpg</span>
                        <button class="registration__delete-button form__delete-button button" type="button">
                            <span>Удалить</span>
                            <svg class="registration__delete-icon form__delete-icon" width="12" height="12">
                                <use xlink:href="#icon-close"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <button class="registration__submit button button--main" type="submit">Отправить</button>
        </form>
    </section>
</main>