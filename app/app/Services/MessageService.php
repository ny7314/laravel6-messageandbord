<?php

namespace App\Services;

use Exception;
use App\Repositories\ThreadRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageService
{
  protected $thread_repository;

  public function __construct(
    ThreadRepository $thread_repository
  )
  {
    $this->thread_repository = $thread_repository;
  }

  public function createNewMessage(array $data, string $thread_id)
  {
    DB::beginTransaction();
    try {
      $thread = $this->thread_repository->findById($thread_id);
      $thread->messages()->create($data);
      $this->thread_repository->updateTime($thread_id);
    } catch (Exception $error){
      DB::rollBack();
      Log::error($error->getMessage());
      throw new Exception($error->getMessage());
    }
    DB::commit();
    return $thread;
  }
}