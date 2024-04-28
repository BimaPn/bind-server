<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index ()
    {
        $data = Notification::where("notifier_id", auth()->id())
            ->with(["sender","entity"])
            ->orderBy("created_at","desc")
            ->limit(20)
            ->get();

        $notifications = [];

        foreach ($data as $notification) {
            $notification->entity->load("type");
            $entity = DB::table($notification->entity->table_name)
                ->find($notification->entity->entity_id);

            $message = null;

            if($notification->entity->table_name == "posts" && $entity->caption) {
                $message = $entity->caption;
            }
            $notifications [] = [
                "sender" => [
                    "name" => $notification->sender->name,
                    "profile_picture" => $notification->sender->profile_picture,
                ],
                "message" => $notification->entity->type->message,
                "isRead" => $notification->is_read,
                "entity" => [
                    "name" => $notification->entity->table_name,
                    "identifier" => $entity->id,
                    "message" => $message
                ]
            ];
        }

        return response()->json([
            "notifications" => $notifications
        ]);
    }

    public static function create($tableName, $notificationTypeId, $entityId, $notifierId)
    {
        $notificationObject = NotificationObject::create([
            "id" => Str::uuid(),
            "table_name" => $tableName,
            "entity_id" => $entityId,
            "notification_type_id" => $notificationTypeId
        ]);
        Notification::create([
            "id" => Str::uuid(),
            "sender_id" => auth()->id(),
            "notifier_id" => $notifierId,
            "notification_object_id" => $notificationObject->id
        ]);
        $notificationObject->load("type");
        return $notificationObject->type->message;
    }

    public function notificationUnreadCount ()
    {
        $count = Notification::where("notifier_id", auth()->id())
                             ->where("is_read",false)->count();
        return response()->json([
            "count" => $count
        ]);
    }
}
