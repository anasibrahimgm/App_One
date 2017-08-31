<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;

class newCategoryPost extends Notification
{
    use Queueable;

    protected $post_slug, $category_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post_slug, $category_name)
    {
        $this->post_slug = $post_slug;
        $this->category_name = $category_name;
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
            'post_slug' => $this->post_slug,
            'category_name' => $this->category_name,
            'post_user' => Auth::user()->name,
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
