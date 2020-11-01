<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupMessage;
use App\Group;
use App\MessageFile;

class GroupMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMessage(Request $request) {


        $request->validate([
            'message' => 'required',
            'groupId' => 'required',
            'userId' => 'required', 
        ]);

        $group = Group::find($request->groupId);
        
        if ($group->userInGroup()) {
            $message = new GroupMessage;
            $message->message = $request->message;
            $message->group_id = $request->groupId;
            $message->user_id = $request->userId;
            $message->save();
            return true;
        } else 
        {
            return false;
        }

        
    }

    public function getMessages( $groupId )
    {
        $groupMessages = Group::findOrFail($groupId)->messages;

        return view('groups.messages')->with('messages', $groupMessages);
    }

    public function sendFile( Request $request ) 
    {
        $request->validate([
            'file' => 'required',
            
        ]);
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $filename = time() . '.' . $filename;
        
        $path = $file->storeAs('public', $filename);
        // $path = $request->file->store('public');
        $file = new MessageFile;
        $file->location = $filename;
        $file->user_id = $request->userId;
        $file->group_id = $request->groupId;
        $file->save();
        
        

        return redirect()->back();
    }



}
