<?php

namespace App\Repositories;

use App\Thread;

class ThreadRepository
{
  protected $thread;

  public function __construct(Thread $thread)
  {
    $this->thread = $thread;
  }

  public function create(array $data)
  {
    return $this->thread->create($data);
  }
}