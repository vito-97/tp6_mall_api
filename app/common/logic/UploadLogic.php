<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/23
 */

namespace app\common\logic;


use think\facade\Filesystem;

class UploadLogic extends BaseLogic
{
    protected $file;

    protected $fileSystem;

    protected $disk = 'public';

    public function __construct($file = null)
    {
        $this->file       = $file;
        $this->fileSystem = Filesystem::disk($this->disk);
    }

    /**
     * 上传图片
     * @param string $dir
     * @return bool|string
     */
    public function image($dir = 'image')
    {
        return $this->fileSystem->putFile($dir, $this->file);
    }
}