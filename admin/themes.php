<?php require __DIR__ . '/modules/header.php'; ?>
<?php require __DIR__ . '/modules/navbar.php'; ?>
<?php $list = \Widgets\Plugin::alloc()->getPlugins(); ?>
<div class="container">
    <h1 class="title"><?= _t('主题') ?></h1>
    <table class="table">
        <thead>
            <tr class="table-light">
                <th scope="col"><?= _t('名称') ?></th>
                <th scope="col"><?= _t('描述') ?></th>
                <th scope="col"><?= _t('版本') ?></th>
                <th scope="col"><?= _t('作者') ?></th>
                <th scope="col"><?= _t('操作') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $item) : ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['description'] ?></td>
                    <td><?= $item['version'] ?></td>
                    <td><?= $item['author'] ?></td>
                    <td>
                        <a href=""><?= _t('设置') ?></a>
                        <?php if ($item['activated']) : ?>
                            <a href="/plugin/disable?plugin=<?= $item['name'] ?>"><?= _t('关闭') ?></a>
                        <?php else : ?>
                            <a href="/plugin/enable?plugin=<?= $item['name'] ?>"><?= _t('开启') ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">上一页</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">下一页</a></li>
        </ul>
    </div>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
