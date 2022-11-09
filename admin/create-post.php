<?php require __DIR__ . '/modules/header.php'; ?>
<?php require __DIR__ . '/modules/navbar.php'; ?>
<div class="container">
    <h1 class="title"><?= _t('发布文章') ?></h1>
    <form action="">
        <div class="columns">
            <div class="column is-8">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" placeholder="标题">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <textarea class="textarea" placeholder="内容" rows="12"></textarea>
                    </div>
                </div>
                <div class="submit">
                    <button class="btn" type="button">保存为草稿</button>
                    <button class="btn btn-primary" type="submit">发布</button>
                </div>
            </div>
            <ul class="tabs">
                <li class="is-active">
                    <a href="javascript:void(0)" data-tab="advance">
                        <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M352 320c88.4 0 160-71.6 160-160c0-15.3-2.2-30.1-6.2-44.2c-3.1-10.8-16.4-13.2-24.3-5.3l-76.8 76.8c-3 3-7.1 4.7-11.3 4.7H336c-8.8 0-16-7.2-16-16V118.6c0-4.2 1.7-8.3 4.7-11.3l76.8-76.8c7.9-7.9 5.4-21.2-5.3-24.3C382.1 2.2 367.3 0 352 0C263.6 0 192 71.6 192 160c0 19.1 3.4 37.5 9.5 54.5L19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L297.5 310.5c17 6.2 35.4 9.5 54.5 9.5zM80 456c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24z" />
                        </svg>
                        <span class="ml-2">选项</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" data-tab="files">
                        <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M396.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                        </svg>
                        <span class="ml-2">附件</span>
                    </a>
                </li>
            </ul>
            <div>
                <div class="tab-content" data-tab="advance">
                    <div class="field">
                        <label class="label"><?= _t('分类') ?></label>
                        <div class="control">
                            <select class="select">
                                <option>Select dropdown</option>
                                <option>With options</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label"><?= _t('标签') ?></label>
                        <div class="control">
                            <input class="input" type="text">
                        </div>
                        <p class="help"><?= _t('多个标签用逗号分隔，如：标签一,标签二') ?></p>
                    </div>
                    <div class="field">
                        <button class="btn is-info" type="button" data-toggle="collapse" data-target="#collapse">
                            <span><?= _t('高级选项') ?></span>
                            <span class="icon is-small">
                                <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="collapse is-hidden" id="collapse">
                        <div class="field">
                            <label class="label"><?= _t('公开度') ?></label>
                            <div class="control">
                                <div class="control">
                                    <label for="publish" class="radio">
                                        <input type="radio" name="answer" value="publish" id="publish" checked>
                                        <span>公开</span>
                                    </label>
                                    <label for="hidden" class="radio">
                                        <input type="radio" name="answer" value="hidden" id="hidden">
                                        <span>隐藏</span>
                                    </label>
                                    <label for="password" class="radio">
                                        <input type="radio" name="answer" value="password" id="password">
                                        <span>密码保护</span>
                                    </label>
                                    <label for="private" class="radio">
                                        <input type="radio" name="answer" value="private" id="private">
                                        <span>私密</span>
                                    </label>
                                    <label for="waiting" class="radio">
                                        <input type="radio" name="answer" value="waiting" id="waiting">
                                        <span>待审核</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label"><?= _t('权限控制') ?></label>
                            <div class="control">
                                <div class="control">
                                    <label class="checkbox">
                                        <input type="checkbox" name="allowComment[]" id="allowComment">
                                        <span>允许评论</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab="files">
                    <article class="panel" id="postUpload">
                        <div class="panel-block py-5 d-flex is-justify-content-center">
                            <button id="uploadButton" class="btn is-info" type="button">
                                <span class="file-icon">
                                    <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456c13.3 0 24-10.7 24-24s-10.7-24-24-24s-24 10.7-24 24s10.7 24 24 24z" />
                                    </svg>
                                </span>
                                <span class="file-label"><?= _t('选择文件上传') ?></span>
                            </button>
                        </div>
                        <?php foreach (\Widgets\File::alloc()->getCurrentUserUnfiledFiles() as $item) : ?>
                            <div class="panel-block is-flex-direction-column is-align-items-flex-start" data-type="fileItem" data-cid="<?= $item['cid'] ?>">
                                <div class="mb-2">
                                    <strong class="is-text-wrap"><?= $item['name'] ?></strong>
                                </div>
                                <div class="is-flex is-align-items-center">
                                    <strong class="has-text-grey-light"><?= $item['size'] ?></strong>
                                    <a class="btn is-info ml-2" href="">
                                        <span class="icon is-small">
                                            <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </span>
                                    </a>
                                    <button class="btn is-danger ml-2" type="button" data-type="delete" data-cid="<?= $item['cid'] ?>">
                                        <span class="icon is-small">
                                            <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </article>
                </div>
            </div>
        </div>
    </form>
</div>
<?php require __DIR__ . '/modules/footer.php'; ?>
