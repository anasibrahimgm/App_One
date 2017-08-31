<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;

class newComment extends Notification
{
  use Queueable;

  protected $post_slug, $post_title;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($post_title, $post_slug)
  {
      $this->post_slug = $post_slug;
      $this->post_title = $post_title;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
      return ['database'];
  }

  public function toDatabase($notifiable)
  {
      return [
          'post_title' => $this->post_title,
          'post_slug' => $this->post_slug,
          'commenter' => Auth::user()->name,
      ];
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
      return [
          //
      ];
  }
}
