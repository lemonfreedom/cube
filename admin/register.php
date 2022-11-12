<?php require __DIR__ . '/modules/header.php'; ?>
<div class="login">
    <div class="header">
        <div class="container">
            <div class="left">
                <div class="site-name">Cube</div>
            </div>
        </div>
    </div>
    <div class="page">
        <div class="container">
            <h1 class="title">账号注册</h1>
            <div id="content" class="content">
                <div class="content-body">
                    <form class="left" action="<?= site_url('/user/register') ?>" method="POST">
                        <div class="field">
                            <label class="label" for="">用户名</label>
                            <input class="input" name="account" type="text" autofocus>
                        </div>
                        <div class="field">
                            <label class="label" for="">邮箱</label>
                            <input class="input" name="email" type="email">
                        </div>
                        <div class="field">
                            <label class="label" for="">密码</label>
                            <input class="input" name="password" type="password">
                        </div>
                        <button class="btn btn-primary btn-full" type="submit"><?= _t('注册') ?></button>
                    </form>
                    <div class="right">
                        <p class="description">Cube 是一款极简博客程序</p>
                        <div class="link-tools">
                            <a href="/">返回首页</a>
                            <a href="/admin/login.php">登陆账号</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
