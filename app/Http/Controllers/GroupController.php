<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Group;
use Illuminate\Support\Str;
use App\Models\UserGroupPivot;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getGroups ()
    {
        $groups = Group::limit(10)->get()->map(function(Group $group) {
            return $group->getPreviewData();
        });
        return response()->json([
            'groups' => $groups
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return response()->json([
            'group' => $group->getDetailData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['id'] = Str::uuid();

        if($request->file('group_picture')){
            $validatedData['group_picture'] = url('/storage/'.$request->file('group_picture')->store('/group/picture'));
        }

        $group = Group::create($validatedData);

        UserGroupPivot::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group['id'],
            'group_role_id' => 3
        ]);

        return response()->json([
            'message' => 'Group created.',
            'group_id' => $group->id
        ]);
    }
    public function update(UpdateGroupRequest $request,Group $group)
    {
        $validatedData = $request->validated();
        if($request->file('group_picture')){
            $validatedData['group_picture'] = url('/storage/'.$request->file('group_picture')->store('/group/picture'));
            $group->deleteGroupPicture();
        }
        $group->update($validatedData);
        return response()->json([
            'group' => $group->getDetailData(),
        ], 200);
    }
    public function getGroupName(Group $group)
    {
        return response()->json([
            'name' => $group->name
        ]);
    }
    public function getGroupPosts(Group $group)
    {
        $posts = $group->posts()->limit(10)->get()->map(function (Post $post) {
            return $post->getPreviewData();
        });

        return response()->json([
            'posts' => $posts
        ]);
    }


}
