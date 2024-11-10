<?php

namespace App\Jobs;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $orderId;
    /**
     * Create a new job instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::getAllOrder($this->orderId);

        if ($order) {
            $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
            $pdf = Pdf::loadView('backend.order.pdf', compact('order'));
            Storage::put('public/pdfs/' . $file_name, $pdf->output());
            Order::where('id', $this->orderId)->update(['invoice' => $file_name]);
        }
    }
}
