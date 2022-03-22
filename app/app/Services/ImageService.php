<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ImageRepository;
use Illuminate\Support\Facades\Storage;


class ImageService
{
  protected $image_repository;

  public function __construct(
    ImageRepository $image_repository
  ){
    $this->image_repository = $image_repository;
  }

  public function createNewImages(array $images, int $message_id)
  {
    DB::beginTransaction();
    try {
      foreach ($images as $image){
        $path = Storage::disk('s3')->put('/', $image);
        $data = [
          's3_file_path' => $path,
          'message_id' => $message_id
        ];
        $this->image_repository->create($data);
      }
    } catch (Exception $error) {
      DB::rollBack();
      Log::error($error->getMessage());
      throw new Exception($error->getMessage());
    }
    DB::commit();
    return $image;
  }

  public function createTemporaryUrl(string $s3_file_path)
  {
    return Storage::disk('s3')->temporaryUrl($s3_file_path, Carbon::now()->addDay());
  }

}