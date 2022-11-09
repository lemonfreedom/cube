<?php require __DIR__ . '/modules/header.php'; ?>
<?php require __DIR__ . '/modules/navbar.php'; ?>
<?php $list = \Widgets\File::alloc()->getFiles(); ?>
<div class="container">
    <h1 class="title"><?= _t('文件') ?></h1>
    <div class="btn-group mb-3">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"><?= _t('选中项') ?></button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><?= _t('删除') ?></a></li>
        </ul>
    </div>
    <table class="table">
        <thead>
            <tr class="table-light">
                <th scope="col">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                </th>
                <th scope="col"><?= _t('文件名') ?></th>
                <th scope="col"><?= _t('上传者') ?></th>
                <th scope="col"><?= _t('所属文章') ?></th>
                <th scope="col"><?= _t('发布日期') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $item) : ?>
                <tr>
                    <th scope="row">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    </th>
                    <td><a href="/admin/file.php?cid=<?= $item['cid'] ?>"><?= $item['name'] ?></a></td>
                    <td><?= $item['username'] ?></td>
                    <td></td>
                    <td><?= $item['created'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        <?= \Helpers\Element::pagination(6, 10) ?>
    </div>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
