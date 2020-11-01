<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\GroupUser;
use App\User;
use Auth;
use DB;
use App\JoinRequest;
use App\MessageFile;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function myGroups()
    {
        $groups = Auth::user()->groups;
        // dd($groups);
        return view('groups.mygroups')->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->name;
        $group->save();
        $groupUser = new GroupUser;
        $groupUser->group_id = $group->id;
        $groupUser->user_id = Auth::user()->id;
        $groupUser->isAdmin = 1;
        $groupUser->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        $inGroup = $this->getInGroup(Auth::user()->id, $id);
        $isRequested = $this->getRequested(Auth::user()->id, $id);
        $isAdmin = DB::select('select * from group_user where user_id = ? and group_id = ? and isAdmin = 1', [ Auth::user()->id, $id ]);
        $requests = null;
        $files = MessageFile::where('group_id', $id)->get();
        if ($isAdmin) {
            $requests = JoinRequest::where('group_id', $id)->where('isAccepted', 0)->get();
        } 

        // dd($inGroup);
        return view('groups.show')->with([ 'group' => $group, 'inGroup' => $inGroup , 'isRequested' => $isRequested, 'isAdmin' => $isAdmin, 'requests' => $requests, 'files' => $files ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getInGroup($userId, $groupId) 
    {
        if ( DB::select('select * from group_user where user_id = ? and group_id = ?', [$userId, $groupId]) ) 
        {
            return true;
        } else {
            return false;
        }
    }
    private function getRequested($userId, $groupId) 
    {
        if ( DB::select('select * from join_requests where user_id = ? and group_id = ?', [$userId, $groupId]) ) 
        {
            return true;
        } else {
            return false;
        }
    }

    public function addRequest($userId, $groupId)
    {
        $joinRequest = new JoinRequest;
        $joinRequest->user_id = $userId;
        $joinRequest->group_id = $groupId;
        $joinRequest->isAccepted = 0;
        $joinRequest->save();
        return redirect()->back();
        // return redirect()->route('requestSent');
    }

    public function acceptRequest( $userId, $groupId )
    {
        $joinRequest = JoinRequest::where('user_id', $userId)->where('group_id', $groupId)->first();
        $joinRequest->isAccepted = 1;
        $joinRequest->save();
        $groupUser = new GroupUser;
        $groupUser->group_id = $groupId;
        $groupUser->user_id = $userId;
        $groupUser->isAdmin = 0;
        $groupUser->save();
        return redirect()->back();
    }


}
