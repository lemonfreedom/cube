<?php require __DIR__ . '/modules/header.php'; ?>
<?php require __DIR__ . '/modules/navbar.php'; ?>
<div class="container">
    <h1 class="title"><?= _t('基本') ?></h1>
    <form action="/option/update-general" method="post">
        <div class="field">
            <label class="label" for="title"><?= _t('站点名称') ?></label>
            <input class="input" id="title" type="text">
            <p class="help"><?= _t('站点的名称将显示在网页的标题处') ?></p>
        </div>
        <div class="field">
            <label class="label" for="description"><?= _t('站点描述') ?></label>
            <input class="input" id="description" type="text">
            <p class="help"><?= _t('站点描述将显示在网页代码的头部') ?></p>
        </div>
        <div class="field">
            <label class="label" for="keywords"><?= _t('关键词') ?></label>
            <input class="input" id="keywords" type="text">
        </div>
        <div class="field">
            <label class="label" for="allowRegister"><?= _t('是否允许注册') ?></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allowRegister" id="allowRegister" value="option2">
                    <label class="form-check-label" for="allowRegister"><?= _t('否') ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allowRegister" id="allowRegister" value="option1">
                    <label class="form-check-label" for="allowRegister"><?= _t('是') ?></label>
                </div>
            </div>
        </div>
        <div class="field">
            <label class="label" for="language"><?= _t('站点默认语言') ?></label>
            <?= \Helpers\Element::select('language', $option->get('language', ''), \Widgets\Language::alloc()->getLanguages()) ?>
        </div>
        <div class="submit">
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
