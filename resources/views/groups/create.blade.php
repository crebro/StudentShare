@extends('base')

@section('title')
    <link rel="stylesheet" href=" {{ asset('css/auth.css') }} ">
@endsection

@section('content')
    <div style="max-width: 400px;" class="container">
        <div class="card-header">
            Create Group
            <form action="{{route('groups.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">
                        Group Name:
                    </label>
                    <input class="form-field" id="name" name="name" type="text">
                </div>
                <button type="submit" class="btn"> Create </button>
            </form>
        </div>
    </div>
@endsection
