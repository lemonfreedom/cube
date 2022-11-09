<?php require __DIR__ . '/modules/header.php'; ?>
<div class="login container">
    <div class="board">
        <h1 class="login-title"><?= _t('Cube') ?></h1>
        <form action="<?= site_url('/user/login') ?>" method="POST">
            <div class="field">
                <input class="input" name="account" type="text" placeholder="<?= _t('用户名或邮箱') ?>" autofocus>
            </div>
            <div class="field">
                <input class="input" name="password" type="password" placeholder="<?= _t('密码') ?>">
            </div>
            <div class="field">
                <button class="btn btn-primary btn-full" type="submit"><?= _t('登录') ?></button>
            </div>
        </form>
        <div class="tools">
            <a href="/"><?= _t('返回首页') ?></a>
            <a href="/admin/register.php"><?= _t('用户注册') ?></a>
        </div>
    </div>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
