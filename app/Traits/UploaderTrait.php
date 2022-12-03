<?php

namespace App\Traits;

use File;
use Image;
use Illuminate\Http\UploadedFile;

trait UploaderTrait
{
    /**
     * Upload a single file in the server
     *
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public $basePath = 'uploads/';

    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);
        return $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            $disk
        );
    }
    /**
     * @param UploadedFile $file
     *
     * @param string $folder
     * @param string $disk
     *
     * @return false|string
     */
    public function storeFile(UploadedFile $file, $folder = 'products', $disk = 'public')
    {
        $filepath =  $file->store($folder, ['disk' => $disk]);

        // Store S3 file
        $this->storeS3File($folder, $file);

        return $filepath;
    }

    /**
     * @param UploadedFile $file
     *
     * @param string $folder
     * @param string $disk
     *
     * @return false|string
     */
    public function storeFileMultipart(UploadedFile $file, $folder = 'products', $disk = 'public', $uploadToS3 = true)
    {
        $filepath =  $file->store($folder, ['disk' => $disk]);
        $fileName = str_replace($folder.'/', "", $filepath);

        // Store S3 file
         if ($uploadToS3 === true) {
            // if you wants to store in folder
            // $this->storeS3File($folder, $file);

            // if you DO NOT wants to store in folder
          $this->storeS3File('', $file);
        }

        return ['path' =>  $filepath , 'name' => $fileName];
    }

     /**
     * @param UploadedFile $file image in base64
     *
     * @param string $path path with in the public folder
     *
     * @return string the name of the image/file
     */

    public function base64UploadImage($file,$path)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $png_url = \Helper::getUniqueId().'.jpg';
        $path = $this->basePath . $path;
        if(!File::exists(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path)) {
          File::makeDirectory(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path, 0755, true);
        }
        $save_path = \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path.'/'.$png_url;
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
        file_put_contents($save_path, $image);
        return $png_url;
      }


      /**
     * @param UploadedFile $file image in base64
     *
     * @param string $path path with in the public folder
     *
     * @return string the name of the image/file
     */

    public function base64FileUpload($file, $path, $resizeWidth = NULL, $resizeHeight = NULL)
    {
        list($type, $data) = explode(';', $file);
        $extSplit = explode('/', $type);
        $ext      =  $extSplit[1];
        $extType  =  $extSplit[0];
        $fileName = \Helper::getUniqueId(). '.' .  $ext;

        if(!File::exists(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path)) {
          File::makeDirectory(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path, 0755, true);
        }

        $save_path  = \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path.'/'.$fileName;
        $image      = base64_decode(preg_replace($this->pregReplaceStringForBase64EncodedType($extType), '', $file));
        file_put_contents($save_path, $image);

        // resize image
        if (!empty($resizeWidth) || !empty($resizeHeight)) {
          // create instance
          try {
            $img = \Image::make( $save_path);

            // RESIZE BY WIDTH
            if (!empty($resizeWidth)) {
                $img->resize($resizeWidth, NULL);
            // RESIZE BY HEIGHT
            } else if (!empty($resizeHeight)) {
                $img->resize(NULL, $resizeHeight);
            }
            $img->save($save_path);
          } catch(\Exception $e){
            // throw $e;
          }
        }

        // Store S3 file
       // $this->storeS3File($path . '/' . $fileName, $image);

        return ['path' => $path . '/' . $fileName, 'name' => $fileName];

      }

     /**
     * @param UploadedFile $file image in base64
     *
     * @param string $path path with in the public folder
     *
     * @return string the name of the image/file
     */

    public function base64UploadVideo($file,$path)
    {
        $url = \Helper::getUniqueId().'.mp4';
        $path = $this->basePath . $path;
        if(!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0755, true);
          }

        $save_path = \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$path.'/'.$url;
        $image = base64_decode(preg_replace('#^data:video/\w+;base64,#i', '', $file));
        file_put_contents($save_path, $image);
        return $url;
     }

    /**
     * @param string filename to delete
     *
     * @param string $path path with in the public folder
     *
     * @return void
     */
    public function deleteFile($fileName)
    {
        File::delete(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $fileName);

        // if S3 exists
        /* $exists = \Storage::disk('s3')->exists($fileName);
        if ($exists) {
          \Storage::disk('s3')->delete($fileName);
        } */
    }

    

    public function getFile($fileName)
    {
        return \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $fileName;
    }

    public function storeS3File($filePath, $file)
    {
        \Storage::disk('s3')->put($filePath, $file);

        return ;
    }

    /*
    * Preg_replace type of base64 encoded type
    */
    public function pregReplaceStringForBase64EncodedType($extType)
    {

        if (strstr($extType, 'application')) {

            $pregReplaceString = '#^data:application/\w+;base64,#i';

        } else if (strstr($extType, 'image')) {

            $pregReplaceString = '#^data:image/\w+;base64,#i';

        } else if (strstr($extType, 'video')) {

            $pregReplaceString = '#^video:video/\w+;base64,#i';
        } else if (strstr($extType, 'text')) {

            $pregReplaceString = '#^data:text/\w+;base64,#i';
        }
        return $pregReplaceString;
    }

    public function imageResize($filename, $height, $width)
    {
      
      $path = \Storage::disk('public')->getAdapter()->getPathPrefix();
      $tempPath = $path.'/temp/'.$filename;
      $img = Image::make($tempPath);
     // $watermark = Image::make(public_path('/images/watermark.png'));
      $resizeImage = $img->resize($height, $width, function ($constraint) {
          $constraint->aspectRatio();
      });
      //$resizeImage->insert($watermark,'bottom-right', 10, 10)->save($tempPath);
      $resizeImage->save($tempPath);
      return $resizeImage->basename;
    }

    public function moveFileDirectory($from, $to)
    {
      \Storage::disk('public')->move($from, $to);
    }
}
