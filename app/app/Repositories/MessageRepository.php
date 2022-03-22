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

  public function findById(int $id)
  {
    return $this->message->find($id);
  }

  public function deleteMessage(int $id)
  {
    $message = $this->findById($id);
    return $message->delete();
  }
}