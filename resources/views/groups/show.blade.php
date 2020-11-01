@extends('base')

@section('title')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href=" {{ asset('css/group.css') }} ">
@endsection

@section('content')

@php
    function endsWith($string, $endString) 
{ 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
} 
@endphp

<div class="group">
    @if ($inGroup)
        <div class="main">
            <div class="chat">
<div class="title">
    Chat With Members
</div>
<div style="color: black;" class="chatBox" id="chatBox">
    
    {{-- <div class="chatitem">

    </div> --}}
</div>
<div class="chatForm">
    <form class="chatForm" id="messageForm" method="post">
        @csrf
        <input name="message" id="messageField" type="text">
        <input name="userId" type="hidden" value="{{ Auth::user()->id }}" id="messageUser" >
        <input name="groupId" type="hidden" value="{{ $group->id }}" id="messageGroup" >
        <button type="submit" id="messageSubmit" class="btn"> Send </button>
    </form>
</div>
            </div>
            <div class="files">
                
                <div class="title">
                    Share Files With Group Members
                </div>

                <div class="filesBox" >
                    @foreach ($files as $file)
                       @if (endsWith(strtolower($file->location), '.jpg')
                       || endsWith(strtolower($file->location), '.png')
                       || endsWith(strtolower($file->location), '.ico')
                       || endsWith(strtolower($file->location), '.gif')
                       )

                       <a href="/storage/{{ $file->location }}" target="_blank" >
                        <img class="sharedFile" height="200" width="200" style='object-fit: cover;' src="/storage/{{ $file->location }}" />       
                    </a>

                       @elseif(endsWith(strtolower($file->location), '.mp4'))

                    <a href="/storage/{{ $file->location }}" target="_blank" >
                       <video class="sharedFile" controls>
                        <source  src="/storage/{{ $file->location }}" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                    </a>     

                    @else
                    {{-- <a href="/storage/{{ $file->location }}" target="_blank" download> --}}
                    <div class="sharedFile" style="
                    height: 75px;
                    width: 360px;
                    padding: 20px;
                    border: 1px solid black;" >
                        <p>Could not Show This File.  </p>
                        <br />
                        <a href="/storage/{{ $file->location }}" target="_blank" class="btn" download>
                        Download
                        </a>
                        <a href="/storage/{{ $file->location }}" target="_blank" class="btn"> 
                            View in Url
                        </a>
                    </div>
                {{-- </a> --}}
                       @endif
                    @endforeach
                </div>

                <form action="{{ route('shareImage') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="inputfile">
                    <input name="userId" type="hidden" value="{{ Auth::user()->id }}" id="messageUser" >
                    <input name="groupId" type="hidden" value="{{ $group->id }}" id="messageGroup" >
                    <button class="btn" type="submit"> Share </button>
                    
                </form>

            </div>
        </div>
        <div class="users" style="display: flex; justify-content: center;">

        
        @if ($isAdmin)
        <div class="requests" style="width: 100%;">
            <div class="title">
                Join Requests
            </div>

       
            @foreach ($requests as $request)
               <div class="requestItem">
                <div class="requestName">
                    {{$request->user->name}}
                </div>
                <div style="background-color: #32a852" class="btn" onclick="event.preventDefault();
                document.getElementById('accept-request{{ $request->user->id }}').submit();">
                    Accept Request
                   
                    
                </div>
                <form style="display: none;" id="accept-request{{ $request->user->id }}" action=" {{ route('groupAccept', ['userId'=>$request->user->id, 'groupId'=>$group->id]) }} " method="post">
                    @csrf
                    {{-- <button class="btn" type="submit"> Send Request </button> --}}
                </form>
               </div>
            

            @endforeach
            @if (count($requests) == 0 )
                <div class="noRequests" style="color: red;">
                    There are no Requests in This Group
                </div>
            @endif
        </div>
        @endif
        <div class="groupUseres" style="width: 100%;">
            <div class="title">
                Users
            </div>
            @foreach ($group->users as $user)
            <div class="requestItem">

                {{ $user->name }}
            </div>
        @endforeach
        </div>
        

    </div>
    @else
    <span id="notInGroup"> You are not in This Group </span>
        @if ($isRequested)
            <span style="font-size: 20px;"> Request Already Sent.</span>
            <p> You will be able to chat and share anything in this group once the admin approves your request.  </p>
        @else
        
        <p> You are not currently in this group. You can ask the admin of this group to let to enter. Would you like to send the admin a Request to Join This Group. You will be able to chat and share anything in this group once the admin approves your request. </p>
       @auth
       <span class="btn" onclick="event.preventDefault();
       document.getElementById('send-requestForm').submit();"> Send Request. </span>
       <form id="send-requestForm" action=" {{ route('groupJoin', ['userId'=>Auth::user()->id, 'groupId'=>$group->id]) }} " method="post">
           @csrf
           {{-- <button class="btn" type="submit"> Send Request </button> --}}
       </form>
       @endauth
       @guest
           <span style="color: red;"> Sorry You are not logged in to Join This Group </span>
       @endguest
        @endif
        @endif
</div>
<script>
    $('document').ready(function() {
        console.log(" {{ route('getMessages', ['groupId'=> $group->id ] ) }} ");
        // $('.chatBox').load( " {{ route('getMessages', ['groupId'=> $group->id ] ) }} " , function () {

        // });
        var chatBoxElement = document.getElementById("chatBox");
        // var messageBody = document.querySelector('#messageBody');
        function load() {
				// $(".chatBox").load(" {{ route('getMessages', ['groupId'=> $group->id ] ) }} ", {

				// });
            $.get(" {{ route('getMessages', ['groupId'=> $group->id ] ) }} ", function (data, status) {
                chatBoxElement.innerHTML = data;
                // console.log(" is this even happening");
            });
		}
        setInterval(function() {
            load();
        }, 1000);

        

		$('#messageForm').submit(function( event ) {
            
            event.preventDefault();
           

            $.ajax({
                url: "{{ route('sendMessage') }}",
                type: 'post',
                data: $('#messageForm').serialize(), 
                // dataType: 'json',
                success: function( _response ){
                    chatBoxElement.scrollTop = chatBoxElement.scrollHeight - chatBoxElement.clientHeight;

                },
                error: function( _response ){
                    console.log(_response);
                }
            });
            $('#messageField').val('');

        });
		});
</script>
@endsection