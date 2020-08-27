@extends('layouts.app')
@section('middle-content')
    <div class="row pt-2">
        <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
            <div class="h3 font-weight-bold">People you're following</div>    
        </div>

        @foreach ($followingUsers as $user)
        <div class="col-lg-12 pt-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
            <div class="container d-flex">

                <div>
                    <a href="/users/{{$user->id}}">
                        <img class="rounded-circle mr-2"
                        style="max-height: 50px" 
                        src="https://i.pravatar.cc/300?u={{$user->email}}" 
                        alt="profile_picture">
                    </a>
                </div>

                <div class="font-weight-bold">
                    <a href="/users/{{$user->id}}">
                        {{$user->name}}
                    </a>
                </div>

                <div class="ml-auto d-flex align-items-center side-follow-btn">
                    <form action="/follows/delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold unfollow">
                            <span>Following</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('right-content')
    {{-- who to follow --}}
    <div class="row {{(count($users) > 0)? 'mb-5': ''}}">
        {{-- search --}}
        <div class="col-lg-9 form-group mt-1">
            <input type="text" class="form-control" placeholder="Search..." style="border-radius: 15px;">
        </div>

        @if(count($users) > 0)
            <div class="col-lg-9">
                <div class="container bg-light pt-2" style="border-radius: 15px 15px 0 0; border-bottom: 1px solid rgba(0,0,0,.25);">
                    <div class="h4 font-weight-bold">Who to follow</div>
                </div>
            </div>

            {{-- user box --}}
            @foreach ($users as $user)
                <x-user-box :user="$user" />
            @endforeach

            <div class="col-lg-9" style="border-radius: 0 0 15px 15px;">
                <div class="container pt-2 pb-2 bg-light" style="border-radius: 0 0 15px 15px;">
                    <a href="/users" class="font-weight-bold">See more...</a>
                </div>
            </div>
        @endif
    </div>
@endsection