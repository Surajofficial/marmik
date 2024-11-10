<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Received AwishClinic: ' . $this->order->order_number) // Subject with order number
            ->line('A new order has been placed.')
            ->line('Order Number: ' . $this->order->order_number)
            ->action('View Order', route('admin.notification', $this->order->id)) // Adjust the route
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'New Order Received AwishClinic',
            'order_number' => $this->order->order_number,
            'actionURL' => route('admin.notification', $this->order->id), // Adjust the route
        ];
    }
}
