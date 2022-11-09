<?php

namespace Widgets;

use Cube\Widget;

class File extends Widget
{
    /**
     * 文件上传
     *
     * @return void
     */
    private function upload()
    {
        if (!User::alloc()->pass('contributor', true)) {
            $this->response->setStatus(403)->json(['code' => 403, 'message' => _t('无权访问')]);
        }

        $file = $_FILES['file'];
        $newFilename = rand_string(10) . substr($file['name'], strrpos($file['name'], '.'));

        $result = $this->db->insert("contents", [
            'uid' => User::alloc()->uid,
            'name' => $file['name'],
            'content' => serialize(['name' => $file['name'], 'path' => '/content/uploads/' . $newFilename, 'size' => $file['size']]),
            'type' => 'attachment',
            'created' => time(),
        ]);

        if (!empty($result) && $result->rowCount() > 0) {
            move_uploaded_file($file['tmp_name'], ROOT_DIR . 'content/uploads/' . $newFilename);

            $this->response->json([
                'code' => 0,
                'data' => [
                    'cid' => $this->db->id(),
                    'name' => $file['name'],
                    'size' => format_size($file['size'])
                ],
            ]);
        } else {
            $this->response->json(['code' => 1, 'message' => _t('上传失败')]);
        }
    }

    /**
     * 删除文件
     *
     * @return void
     */
    private function delete()
    {
        User::alloc()->pass('contributor');

        $cid = $this->request->post('cid', '');

        $content = $this->db->get("contents", ['content'], ['cid' => $cid]);
        $info = $content !== null ? unserialize($content['content']) : [];

        $result = $this->db->delete("contents", ['cid' => $cid]);
        if (!empty($result) && $result->rowCount() > 0) {
            $path = ROOT_DIR . ltrim($info['path'], '/');
            if (file_exists($path)) {
                unlink($path);
            }

            $this->response->json(['code' => 0]);
        } else {
            $this->response->json(['code' => 1, 'message' => _t('非法请求')]);
        }
    }

    /**
     * 分页获取文件列表
     *
     * @return array
     */
    public function getFiles()
    {
        $page = $this->request->get('page', 1);

        $result = [];
        $this->db->select('contents', ['[>]users' => 'uid'], [
            'cid', 'uid', 'name', 'content',
            'users.username',
            'contents.created',
        ], [
            'type' => 'attachment',
            'LIMIT' => [($page - 1) * 10, 10],
        ], function ($item) use (&$result) {
            $item = array_merge($item, unserialize($item['content']));
            $item['created'] = format_time($item['created'], true);
            $result[] = $item;
        });

        return $result;
    }

    /**
     * 查询当前用户未归档文件
     *
     * @return array
     */
    public function getCurrentUserUnfiledFiles()
    {
        $result = [];
        $this->db->select('contents', ['[>]users' => 'uid'], [
            'cid', 'uid', 'name', 'content',
            'users.username',
            'contents.created',
        ], [
            'uid' => User::alloc()->uid,
            'type' => 'attachment',
            'parent' => 0,
        ], function ($item) use (&$result) {
            $item = array_merge($item, unserialize($item['content']));
            $item['created'] = format_time($item['created'], true);
            $result[] = $item;
        });

        return $result;
    }

    /**
     * 获取文件数量
     *
     * @return int
     */
    public function getFileCount()
    {
        return $this->db->count('contents', ['type' => 'attachment']);
    }

    /**
     * 通过 cid 查询文件信息
     *
     * @return array
     */
    public function getFileByCid()
    {
        $cid = $this->request->get('cid', '');

        $result = $this->db->get('contents', ['[>]users' => 'uid'], [
            'cid', 'uid', 'name', 'content',
            'users.username',
            'contents.created'
        ], ['cid' => $cid], ['type' => 'attachment']);

        $result = array_merge($result, unserialize($result['content']));
        $result['created'] = format_time($result['created'], true);

        return $result;
    }

    public function action()
    {
        $this->on($this->params(0) === 'upload')->upload();
        $this->on($this->params(0) === 'delete')->delete();
    }
}
