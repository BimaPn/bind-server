<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use App\Models\UserGroupPivot;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin' || $user->role['type'] === 'Administrator';
    }

    public function changeRole(User $user, Group $group):bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin';
    }

    public function deletePost(User $user, Group $group):bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin' || $pivot->role['type'] === 'Moderator';
    }

    public function addMember(User $user, Group $group):bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin';
    }

    public function kickUser(User $user, Group $group):bool
    {
        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return $pivot->role['type'] === 'Admin';
    }
}
