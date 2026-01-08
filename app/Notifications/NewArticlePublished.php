<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewArticlePublished extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva noticia publicada por ' . $this->article->author->name)
            ->line('El autor ' . $this->article->author->name . ' ha publicado una nueva noticia: ' . $this->article->title)
            ->action('Leer Noticia', route('articles.show', $this->article->slug))
            ->line('¡Gracias por seguir a nuestros autores!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
