<?php

namespace App\Jobs;

use App\Models\Driver\Driver;
use App\Models\Customer\Customer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\WelcomeNotification;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class WelcomNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $userType;
    protected $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($userId, $userType)
    {
        $this->userId = $userId;
        $this->userType = $userType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (Driver::class === $this->userType) {
            Notification::send(Driver::find($this->userId), new WelcomeNotification());
        } else if (Customer::class === $this->userType) {
            Notification::send(Customer::find($this->userId), new WelcomeNotification());
        }
        //Notification::send(Handyman::find($this->userId), new WelcomeNotification()); 
    }
}
