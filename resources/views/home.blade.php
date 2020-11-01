@extends('base')

@section('title')
    <link rel="stylesheet" href="css/hero.css">
    <link rel="stylesheet" href=" {{ asset('css/groups.css') }} ">
@endsection

@section('content')
@guest
<div class="hero__body">
    <div class="hero__content">
        <h2 class="hero__title"> Studentshare | To Learn  </h2>
        <p class="hero__paragraph">
            Join the Studentshare community now. You can either create a group or Join on and Share whatever you what others to know. Thats it
        </p>
        <a href=" {{ route('login') }} " class="hero__button">
            Start Now
        </a>

    </div>
</div>

@endguest

<div class="groupsToJoin">
    <h3 class="groups__title"> Groups to Join </h3>
    <div class="groups">
       @foreach ($groups as $group)
       <div class="group">
            <div class="group__title">
                {{ substr($group->name, 0, 15) }} ..
            </div>
            <div class="group__members">
                @foreach ($group->users as $user)
                    <div class="group__member">
                        {{$user->name}}
                    </div>
                    
                @endforeach
            </div>
            @auth
            @if ($group->userInGroup())
            <span class="btn" style="background-color: #497882"> Already Joined </span>
        @else
        {{-- <span  class="btn" onclick="event.preventDefault();
        document.getElementById('send-requestForm').submit();"> Send Request. </span> --}}
        @if ($group->userRequestedGroup())
        <span class="btn" style="background-color: #497882">  Requested </span>

        @else
        <span class="btn" onclick="event.preventDefault();
        document.getElementById('groupRequest-{{ $group->id }}').submit();"> Send Request. </span>
        <form id="groupRequest-{{ $group->id }}" action=" {{ route('groupJoin', ['userId'=>Auth::user()->id, 'groupId'=>$group->id]) }} " method="post">
            @csrf
            {{-- <button style="width: 300px" class="btn" type="submit"> Send Request </button> --}}
        </form>
        @endif
        @endif
            @endauth
            
            @guest
                <a href="/login" class="btn" > Login to Join </a>
            @endguest
            {{-- {{ $group->users }} --}}

            <div class="joinGroup">
                     
               {{-- @auth
               {{$group->users}}
               {{ array_map('getId', $group->users ) }}
                    @if ( in_array(Auth::user()->id, $group->users))
                        Already Joined
                    @else 
                    <span class="btn">
                        Join Group
                    </span>
                    @endif
               @endauth --}}
            </div>
        </div>
       @endforeach
    </div>
    {{ $groups->links() }}
    <style>
        .pagination {
  display: inline-block;
}
.pagination {
    list-style: none;
}

.pagination li {
  color: black;
  background-color: white;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
}

.pagination li.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination li:hover:not(.active) {background-color: #ddd;}
    </style>
</div>

@endsection
