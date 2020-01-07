<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class File extends BaseModel
{
    static function createSha1FromOriginalFileName(UploadedFile $uploadedFile){
        $originalFileNameAndMicrotime = $uploadedFile->getClientOriginalName() . microtime();
        $sha1Name = strtolower(sha1($originalFileNameAndMicrotime));

        return $sha1Name;
    }

    public function getPath($fullPath = false) : string {

        $directoryLevel1 = substr($this->name, 0, 13);
        $directoryLevel2 = substr($this->name, 13, 13);
        $directoryLevel3 = substr($this->name, 26, 14);

        if($fullPath){
            $path = sprintf(
                '/%s/%s/%s/%s.%s',
                $directoryLevel1,
                $directoryLevel2,
                $directoryLevel3,
                $this->name,
                $this->ext
            );

            return $path;
        } else {
            $path = sprintf(
                '/%s/%s/%s/',
                $directoryLevel1,
                $directoryLevel2,
                $directoryLevel3
            );

            return $path;
        }
    }
}
