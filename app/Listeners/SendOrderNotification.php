<?php

namespace App\Listeners;


use App\Events\OrderPlaced; 
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;



class SendOrderNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        // Get the admins who will receive the notification
        $admins = User::where('role', 'admin')->get(); // Adjust based on your user model

        // Send the notification
        Notification::send($admins, new NewOrderNotification($event->order));
    }
}
