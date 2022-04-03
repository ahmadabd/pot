<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Notifications\NotifyFertilizing;
use App\Notifications\NotifyWatering;
use Illuminate\Support\Facades\Notification;

class Notify implements WateringNotifyImp, FertilizeNotifyImp
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


    public function FertilizeNotify($flowers): void
    {
        foreach ($flowers as $flower) {
            foreach ($flower->users as $user) {
                Notification::send(User::find($user->id), new NotifyFertilizing());
            }
        }
    }
}