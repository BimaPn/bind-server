<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroupPivot;
use Illuminate\Http\Request;

class UserGroupStatusController extends Controller
{

    public function banUser(Group $group, User $user)
    {
        $this->authorize('banUser', $group);

        $pivot = UserGroupPivot::firstWhere([
            'group_id' => $group->id,
            'user_id' => $user->id,
        ]);

        if (auth()->user()->id === $user->id) {
            return response()->json([
                'message' => 'Cannot ban yourself.'
            ], 422);
        }

        if (!$pivot) {
            return response()->json([
                'message' => 'This user is not a member of this group.'
            ], 422);
        } else if ($pivot->role['type'] === "Admin") {
            return response()->json([
                'message' => 'This user is admin of this group.'
            ], 422);
        } else if ($pivot->status['status'] === 'Banned') {
            return response()->json([
                'message' => 'This user is already banned from this group.'
            ], 422);
        }

        $pivot->update([
            'group_role_id' => 1,
            'user_group_status_id' => 2
        ]);

        return response()->json([
            'message' => 'User banned.'
        ]);
    }

    public function unbanUser(Group $group, User $user)
    {
        $this->authorize('banUser', $group);

        $pivot = UserGroupPivot::firstWhere([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'user_group_status_id' => 2
        ]);

        if (!$pivot) {
            return response()->json([
                'message' => 'This user is not a member of this group.'
            ], 422);
        }

        $pivot->update([
            'user_group_status_id' => 1
        ]);

        return response()->json([
            'message' => 'User unbanned.'
        ]);
    }
}
