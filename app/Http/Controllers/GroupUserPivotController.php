<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\UserGroupPivot;


class GroupUserPivotController extends Controller
{
    public function join(Group $group)
    {
        $check = UserGroupPivot::firstWhere([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id
        ]);

        if ($check) {
            if ($check->status['status'] !== 'Banned') {
                return response()->json([
                    'message' => 'You are banned from this group.'
                ], 422);
            }
            return response()->json([
                'message' => 'You already joined this group.'
            ], 422);
        }

        UserGroupPivot::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id,
            'group_role_id' => 2,
            'user_group_status' => 1
        ]);

        return response()->json([
            'message' => 'Hi' . auth()->user()->username . '! Welcome to ' . $group->name,
        ]);
    }
    public function leave(Group $group)
    {
        $totalAdmin = UserGroupPivot::where([
            'group_id' => $group->id,
            'group_role_id' => 3
        ])->get()->count();

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id
        ]);

        if (!$pivot) {
            return response()->json([
                'message' => 'You are not a member of this group.'
            ], 422);
        } else if ($pivot->status['status'] !== 'Banned') {
            return response()->json([
                'message' => 'You are banned from this group.'
            ], 422);
        }
        if ($pivot->role->type === 'Admin' && $totalAdmin <= 1) {
            return response()->json([
                'message' => 'As an Admin, please choose at least one user to replace your role before leaving the group.'
            ], 422);
        }
        $pivot->delete();
        return response()->json([
            'message' => 'You have left the group successfully.'
        ]);
    }
    public function getGroupsPreview(User $user)
    {
        $groups = $user->groups()
            ->limit(7)->get()
            ->sortByDesc('created_at')->values()->map(function (UserGroupPivot $userGroup) {
                return $userGroup->group->getPreviewData();
            });
        if ($groups->count() > 6) {
            $groups = $groups->take(6);
            $isShowMore = true;
        } else {
            $isShowMore = false;
        }
        return response()->json([
            'groups' => $groups,
            'isShowMore' => $isShowMore
        ]);
    }
    public function getGroups(User $user)
    {
        return response()->json([
            'groups' => $user->groups
        ]);
    }
}
