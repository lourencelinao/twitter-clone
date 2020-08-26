@extends('layouts.app')
@section('middle-content')
<div class="row">
    {{-- top part --}}
    <div class="col-lg-12 pb-1" style="border-bottom: 1px solid rgba(0,0,0, .25);">
        <div class="h5 font-weight-bold">
            {{$profile->name}}
        </div>
        <div>{{$profile->tweets->count()}} tweets</div>
    </div>
    {{-- profile photos --}}
    <div class="col-lg-12 px-0">
        {{-- background image --}}
        <img class="img-fluid"
        style="max-height: 100%; max-width: 100%;" 
        src="https://loremflickr.com/g/750/250/{{$profile->id}}" 
        alt="background_picture">
        {{-- user photo --}}
    </div>
    <div class="col-lg-12 user-show-photo ml-2">
        <img class="rounded-circle shadow-sm"
        style="max-height: 150px; border: 5px solid white;" 
        src="https://i.pravatar.cc/300?u={{$profile->email}}" 
        alt="profile_picture">
    </div>
    <div class="col-lg-12 adjust pb-2" >
        <span class="ml-2 font-weight-bold h3">{{$profile->name}}</span> <br>
        <span class="ml-2"><i class="fa fa-calendar fa-lg custom-text-color mr-2"></i></span>Joined {{$profile->created_at->format('Y-m-d')}} <br>
        <span class="ml-2">Description here</span> <br>
        <span class="ml-2"><a href="" class="font-weight-bold">{{$profile->follows->count()}}</a></span> following
        <span class="ml-2"><a href="" class="font-weight-bold">0</a></span> followers
    </div>
    {{-- tab and pills --}}
    <div class="col-lg-12 adjust" style="border-bottom: 1px solid rgba(0,0,0, .25);" id="sub_nav">
        <nav class="navbar-light" id="sub_nav">
            <ul class="nav d-flex justify-content-between" id="pills-tab" role="tablist">
                <li class="nav-item active">
                  <a class="nav-link text-dark" id="pills-tweets-tab" data-toggle="pill" href="#pills-tweets" role="tab" aria-controls="pills-tweets" aria-selected="true">Tweets</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-dark" id="pills-tweetsandreplies-tab" data-toggle="pill" href="#pills-tweetsandreplies" role="tab" aria-controls="pills-tweetsandreplies" aria-selected="false">Tweets & Replies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="pills-likes-tab" data-toggle="pill" href="#pills-likes" role="tab" aria-controls="pills-likes" aria-selected="false">Likes</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-12 adjust">
        <div class="tab-content" id="pills-tabContent">
            {{-- tweets tab --}}
            <div class="tab-pane fade show active adjust" id="pills-tweets" role="tabpanel" aria-labelledby="pills-tweets-tab">
                @foreach ($tweets as $tweet)
                <div class="row adjust">
                    <div class="col-lg-12 pl-2 py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
                        <div class="d-flex">
                            <a href="/users/{{$tweet->user->id}}">
                                <img class="rounded-circle mr-2"
                                style="max-height: 60px" 
                                src="https://i.pravatar.cc/300?u={{$tweet->user->email}}" 
                                alt="profile_picture">
                            </a>
                            <div class="col-lg-11">
                                <div class="d-flex align-items-start">
                                    <span class="h6 font-weight-bold mr-2">
                                        <a href="/users/{{$tweet->user->id}}">{{$tweet->user->name}}</a>
                                    </span>
                                    <span class="h6">
                                        {{Carbon\Carbon::createFromTimeStamp(strtotime($tweet->created_at))->diffForHumans(null, true)}}
                                    </span>
                                </div>
                                <p class="justify-text">
                                    {{$tweet->body}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- tweets and replies tab--}}
            <div class="tab-pane fade" id="pills-tweetsandreplies" role="tabpanel" aria-labelledby="pills-profile-tab">
                @foreach ($tweets as $tweet)
                <div class="row adjust">
                    <div class="col-lg-12 pl-2 py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
                        <div class="d-flex">
                            <a href="/users/{{$tweet->user->id}}">
                                <img class="rounded-circle mr-2"
                                style="max-height: 60px" 
                                src="https://i.pravatar.cc/300?u={{$tweet->user->email}}" 
                                alt="profile_picture">
                            </a>
                            <div class="col-lg-11">
                                <div class="d-flex align-items-start">
                                    <span class="h6 font-weight-bold mr-2">
                                        <a href="/users/{{$tweet->user->id}}">{{$tweet->user->name}}</a>
                                    </span>
                                    <span class="h6">
                                        {{Carbon\Carbon::createFromTimeStamp(strtotime($tweet->created_at))->diffForHumans(null, true)}}
                                    </span>
                                </div>
                                <p class="justify-text">
                                    {{$tweet->body}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="tab-pane fade" id="pills-likes" role="tabpanel" aria-labelledby="pills-contact-tab">
                likes here
            </div>
        </div>
    </div>
</div>
{{-- loading icon --}}
<div class="loading d-flex justify-content-center">
    <img src="https://loading.io/asset/403312" alt="" id="middle-loading">
</div>
@endsection

@section('right-content')
<div class="container pb-3">
    <div class="row">
        {{-- search --}}
        <div class="col-lg-9 form-group mt-1">
            <input type="text" class="form-control" placeholder="Search..." style="border-radius: 15px;">
        </div>

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
    </div>
</div>  
<div class="loading d-flex justify-content-center" id="right-loading">
    <img src="https://loading.io/asset/403312" alt="">
</div>
@endsection