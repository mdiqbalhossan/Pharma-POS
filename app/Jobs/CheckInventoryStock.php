<?php
namespace App\Jobs;

use App\Models\Medicine;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckInventoryStock implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $medicines = Medicine::all();

        foreach ($medicines as $medicine) {
            $stock        = $medicine->quantity;
            $reorderLevel = $medicine->reorder_level;

            if ($stock <= $reorderLevel) {
                $notification              = new Notification();
                $notification->medicine_id = $medicine->id;
                $notification->type        = 'low_stock';
                $notification->message     = "Stock level for {$medicine->name} is low. Current stock: {$stock}";
                $notification->save();
            }

            if ($stock <= 0) {
                $notification              = new Notification();
                $notification->medicine_id = $medicine->id;
                $notification->type        = 'out_of_stock';
                $notification->message     = "{$medicine->name} is out of stock.";
                $notification->save();
            }

            $expiryDate            = $medicine->expiration_date;
            $sevenDaysBeforeExpiry = Carbon::parse($expiryDate)->subDays(7);

            if ($sevenDaysBeforeExpiry->isPast()) {
                $notification              = new Notification();
                $notification->medicine_id = $medicine->id;
                $notification->type        = 'expiry_alert';
                $notification->message     = "{$medicine->name} will expire in 7 days.";
                $notification->save();
            }
            $now = Carbon::now();
            if ($expiryDate > $now) {
                $notification              = new Notification();
                $notification->medicine_id = $medicine->id;
                $notification->type        = 'expired';
                $notification->message     = "{$medicine->name} has expired.";
                $notification->save();
            }
        }
    }
}
