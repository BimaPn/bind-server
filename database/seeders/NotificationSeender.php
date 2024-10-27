<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\NotificationObject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NotificationSeender extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifObject1 = NotificationObject::create([
            "id" => Str::uuid(),
            "table_name" => "users",
            "entity_id" => "Z",
            "notification_type_id" => 1
        ]);

        Notification::create([
            "id" => Str::uuid(),
            "sender_id" => "Z",
            "notifier_id" => 'YL22VJV8Y',
            "notification_object_id" => $notifObject1->id
        ]);
    }
}
