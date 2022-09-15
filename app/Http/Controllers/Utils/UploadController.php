<?php

namespace App\Http\Controllers\Utils;

use App\Exceptions\RenderErrorResponseException;
use App\Http\Responses\RenderResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UploadController extends CommonController
{
    protected ?string $disk      = null;
    protected array   $extension = [];
    protected int     $maxSize   = 2048000;// 2M

    public function __construct()
    {
        parent::__construct();
        $this->disk      = 'upload';
        $this->extension = ['png', 'jpg', 'jpeg', 'gif'];
        $this->maxSize   = 2048000;
    }

    /**
     * 图片批量上传
     * @param Request $request
     * @return RenderResponse
     */
    public function images(Request $request): RenderResponse
    {
        $fileName = [];
        foreach ($request->allFiles() as $key => $files) {
            foreach (Arr::wrap($files) as $file) {
                $fileName[$key][] = $this->storage($file);
            }
        }
        return new RenderResponse(message: '上传成功', with: $fileName);
    }

    /**
     * 存储驱动
     * @param UploadedFile $file
     * @return string
     */
    protected function storage(UploadedFile $file): string
    {
        // 1.是否上传成功
        if (!$file->isValid()) {
            throw new RenderErrorResponseException('上传失败');
        }
        // 2.是否符合文件类型 getClientOriginalExtension 获得文件后缀名
        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array($fileExtension, $this->extension)) {
            throw new RenderErrorResponseException('格式有误');
        }
        // 3.判断大小是否符合 2M
        $tmpFile = $file->getRealPath();
        if (filesize($tmpFile) >= $this->maxSize) {
            throw new RenderErrorResponseException('大小有误');
        }
        // 4.是否是通过http请求表单提交的文件
        if (!is_uploaded_file($tmpFile)) {
            throw new RenderErrorResponseException('非法提交');
        }
        // 5.每天一个文件夹,分开存储, 生成一个随机文件名
        $fileName = [date('Ymd'), '/', md5(time() . mt_rand(1000, 9999)), '.', $fileExtension];
        $fileName = implode('', $fileName);
        if (Storage::disk($this->disk)->put($fileName, file_get_contents($tmpFile))) {
            return Storage::disk($this->disk)->url($fileName);
        }
    }
}
