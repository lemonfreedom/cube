<?php require __DIR__ . '/modules/header.php'; ?>
<div class="login container">
    <div class="board">
        <h1 class="login-title"><?= _t('Cube') ?></h1>
        <form action="<?= site_url('/user/register') ?>" method="POST">
            <div class="field">
                <input class="input" name="username" type="text" placeholder="<?= _t('用户名') ?>" autofocus>
            </div>
            <div class="field">
                <input class="input" name="email" type="email" placeholder="<?= _t('邮箱') ?>">
            </div>
            <div class="field">
                <input class="input" name="password" type="password" placeholder="<?= _t('密码') ?>">
            </div>
            <div class="field">
                <button class="btn btn-primary btn-full" type="submit"><?= _t('注册') ?></button>
            </div>
        </form>
        <div class="tools">
            <a href="/"><?= _t('返回首页') ?></a>
            <a href="/admin/login.php"><?= _t('用户登录') ?></a>
        </div>
    </div>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
