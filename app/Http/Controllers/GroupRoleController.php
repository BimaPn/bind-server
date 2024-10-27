<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRole;
use App\Models\User;
use App\Models\UserGroupPivot;
use Illuminate\Http\Request;

class GroupRoleController extends Controller
{

    public function makeModerator(Group $group, User $user)
    {
        $this->authorize('changeRole', $group);

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        if ($pivot->group_role_id === 2) {
            return response()->json([
                'message' => 'This user is already an Moderator group.'
            ], 422);
        }

        $pivot->update([
            'group_role_id' => 2
        ]);

        return response()->json([
            'message' => 'User is now an Moderator of the group.'
        ]);
    }

    public function removeModerator(Group $group, User $user)
    {
        $this->authorize('changeRole', $group);

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        if ($pivot->group_role_id === 1 || $pivot->group_role_id === 3) {
            return response()->json([
                'message' => 'This user is not an Moderator of the group.'
            ], 422);
        }

        $pivot->update([
            'group_role_id' => 1
        ]);

        return response()->json([
            'message' => 'User is no longer an Moderator of the group.'
        ]);
    }

    public function makeAdmin(Group $group, User $user)
    {
        $this->authorize('changeRole', $group);

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        if ($pivot->group_role_id === 3) {
            return response()->json([
                'message' => 'This user is already an Admin of the group.'
            ], 422);
        }

        $pivot->update([
            'group_role_id' => 3
        ]);

        return response()->json([
            'message' => 'User is now an Admin of the group.'
        ]);
    }

    public function removeAdmin(Group $group, User $user)
    {
        $this->authorize('changeRole', $group);

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        if ($pivot->group_role_id === 1 || $pivot->group_role_id === 2) {
            return response()->json([
                'message' => 'This user is not an Admin of the group.'
            ], 422);
        }

        $pivot->update([
            'group_role_id' => 1
        ]);

        return response()->json([
            'message' => 'User is no longer an Admin of the group.'
        ]);
    }
}
