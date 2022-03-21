<?php

namespace App\Repositories;

use App\Message;

class MessageRepository
{
  protected $message;

  public function __construct(Message $message)
  {
    $this->message = $message;
  }

  public function create(array $data)
  {
    return $this->message->create($data);
  }
}