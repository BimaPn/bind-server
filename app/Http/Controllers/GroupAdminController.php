<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Post;
use App\Models\UserGroupPivot;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateGroupRequest;

class GroupAdminController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $validatedData = $request->validated();

        if($request->file('group_picture')){
            if($request->old_group_picture){
                Storage::delete($request->old_group_picture);
            }
            $validatedData['group_picture'] = $request->file('group_picture')->store('storage/group/'.$request->input('group_picture'));
        }

        $group->update($validatedData);

        return response()->json([
            'message' => 'Group updated.',
            'data' => $group,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('forceDelete',$group);

        if($group->group_picture){
            Storage::delete($group->group_picture);
        }

        Group::destroy($group->id);

        return response()->json([
            'message' => 'Group deleted.'
        ]);
    }

    public function makeModerator(Group $group, User $user)
    {
        $this->authorize('changeRole', $group);

        $pivot = UserGroupPivot::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        if($pivot->group_role_id === 2){
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


        if($pivot->group_role_id === 1 || $pivot->group_role_id === 3){
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

        if($pivot->group_role_id === 3){
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

        if($pivot->group_role_id === 1 || $pivot->group_role_id === 2){
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

    public function deletePost(Group $group, Post $post)
    {
        $this->authorize('deletePost', $group);

        Post::destroy($post->id);

        return response()->json([
            'message' => 'Post deleted.'
        ]);
    }

    public function addMember(Group $group, User $user)
    {
        $this->authorize('addMember', $group);

        $pivot = UserGroupPivot::firstWhere([
            'group_id' => $group->id,
            'user_id' => $user->id
        ]);

        if($pivot){
            return response()->json([
                'message' => 'This user already a member of this group.'
            ], 422);
        }

        UserGroupPivot::create([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);

        return response()->json([
            'message' => 'User added.'
        ]);
    }

    public function kickUser(Group $group, User $user)
    {
        $this->authorize('kickUser', $group);

        $pivot = UserGroupPivot::firstWhere([
            'group_id' => $group->id,
            'user_id' => $user->id
        ]);

        if(!$pivot){
            return response()->json([
                'message' => 'This user is not a member of this group.'
            ], 422);
        }

        $pivot->delete();

        return response()->json([
            'message' => 'User kicked.'
        ]);
    }
}
