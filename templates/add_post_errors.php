<?php if (isset($errors)): ?>
    <div class="form__invalid-block">
        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
        <ul class="form__invalid-list">
            <?php foreach ($errors as $key => $error): ?>
                <li class="form__invalid-item"><?= $error['for_block']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

