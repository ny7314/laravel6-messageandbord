<?php

namespace App\Services;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Notifiable;

class SlackNotificationService
{
  use Notifiable;

  public function send($message)
  {
    $this->notify(new SlackNotification($message));
  }

  public function routeNotificationForSlack($notification)
  {
    return env('SLACK_URL');
  }
}