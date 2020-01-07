<?php

namespace App\Http\Controllers;

use App\Enums\AllowedFileTypesEnum;
use App\Exceptions\APIException;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function uploadFile(Request $request){
        try{
        $uploadedFile = $request->file('file');

        if(!$this->isAllowedMimeTypeAndExtension($uploadedFile)){
           return response()->json(['message' => 'File not allowed'], 400);
        }

        $savedFile = $this->saveFileObject($uploadedFile);
        $path = $savedFile->getPath();

        $filename = $savedFile->name . '.' . strtolower($uploadedFile->getClientOriginalExtension());

        Storage::disk('local')->putFileAs($path, $uploadedFile, $filename);

        } catch(\Exception $e){
            throw $e;
        }

        return response()->json($savedFile, 200);
    }

    public function getAllFiles(){
        try{
            DB::beginTransaction();

            $files = File::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($files, 200);
    }

    public function downloadFile($name){
        try{
            $fileObject = File::where('name', '=', $name)->first();

            $file = Storage::disk('local')->download(
                $fileObject->getPath(true)
            );

        }catch(\Exception $e){
            throw $e;
        }

        return $file;
    }

    public function updateFile($name, Request $request){
        try{
            $fileObject = File::where('name', '=', $name)->first();
            $path = $fileObject->getPath(true);

            if(!Storage::disk('local')->exists($path)){
                throw new APIException("File doesn't exists", APIException::NOT_FOUND);
            }

            $fileObject->label = $request->label;

            $fileObject->save();

        } catch(\Exception $e){
            throw $e;
        }

        return response()->json($fileObject, 200);
    }

    public function deleteFile($name){
        try{
            $fileObject = File::where('name', '=', $name)->first();

            $fileWithPath = $fileObject->getPath(true);

            if(!Storage::disk('local')->exists($fileWithPath)){
                throw new APIException("File doesn't exists", APIException::NOT_FOUND);
            }

            Storage::disk('local')->delete($fileWithPath);
            $fileObject->delete();
        } catch(\Exception $e){
            throw $e;
        }
        return response()->json(null, 200);
    }

    //==============================================================
    private function saveFileObject(UploadedFile $uploadedFile){
        try{
            DB::beginTransaction();
            $file = new File();

            $file->name     = File::createSha1FromOriginalFileName($uploadedFile);
            $file->label    = basename($uploadedFile->getClientOriginalName(),
                '.' . $uploadedFile->getClientOriginalExtension());
            $file->type     = $uploadedFile->getMimeType();
            $file->ext      = strtolower($uploadedFile->getClientOriginalExtension());
            $file->size     = $uploadedFile->getSize();

            $file->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return File::find($file->id);
    }

    private function isAllowedMimeTypeAndExtension(UploadedFile $uploadedFile){
        if(in_array($uploadedFile->getMimeType(), AllowedFileTypesEnum::ALLOWED_MIME_TYPES) &&
        in_array(strtolower($uploadedFile->getClientOriginalExtension()), AllowedFileTypesEnum::ALLOWED_EXTENSIONS)){
            return true;
        }
        return false;
    }


}
