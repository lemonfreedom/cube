<?php require __DIR__ . '/modules/header.php'; ?>
<?php require __DIR__ . '/modules/navbar.php'; ?>
<?php $info = \Widgets\File::alloc()->getFileByCid(); ?>
<div class="container">
    <h1 class="title"><?= _t('编辑文件') ?> <?= $info['name'] ?></h1>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
