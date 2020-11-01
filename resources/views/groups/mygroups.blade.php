@extends('base')

@section('title')
    <link rel="stylesheet" href="css/mygroups.css">
@endsection

@section('content')
    <div class="container">
        <div class="groups">
            {{-- {{ $groups }} --}}
            @foreach ($groups as $group)
            <div class="group"> 
                <div>{{ $group->name }} </div>
            
            
                <a class="btn" href=" {{ route('groups.show', [ 'group'=>$group->id ]) }} "> View Group  </a>
            </div>
            
            @endforeach
        </div>
    </div>
@endsection
