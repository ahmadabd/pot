<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Notifications\NotifyWatering;
use Illuminate\Support\Facades\Notification;

class Notify implements WateringNotifyImp
{
    public function WateringNotify($flowers): void
    {
        foreach ($flowers as $flower) {
            foreach ($flower->users as $user) {
                // User::find($user->id)->notify(new NotifyWatering());
                Notification::send(User::find($user->id), new NotifyWatering());
            }
        }
    }
}