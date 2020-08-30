@extends('layouts.app')
@section('middle-content')
    <form action="/tweets" method="POST">
        @csrf
    <div class="row py-2" style="border-bottom: 5px solid gray;">
        {{-- home --}}
        <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
            <div class="h3 font-weight-bold">Home</div>    
        </div>
        {{-- tweet box --}}
        <div class="col-lg-12 d-flex py-2">
            
            <a href="/users/{{Auth::id()}}">
                <img class="rounded-circle mr-2"
                style="max-height: 60px" 
                src="https://i.pravatar.cc/300?u={{Auth::user()->email}}" 
                alt="profile_picture">
            </a>
            {{-- tweet input --}}
            <textarea class="form-control @error('tweet') is-invalid @enderror" name="tweet" 
            id="" rows="2" cols="2"
            placeholder="What's poppin?" style="border:none; border-bottom: 1px solid rgba(0,0,0, .25);">
            </textarea>
            
        </div>
        {{-- below tweet box --}}
            @error('tweet')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="ml-auto col-lg-11 d-flex justfy-content-end align-items-center">
            <div class="">
                <button class="btn custom-text-color">
                    <i class="fa fa-image fa-2x"></i>
                </button>
            </div>
            <div class="ml-auto pt-2 pb-2">
                <button type="submit" class="btn custom-background-color text-white" style="border-radius: 25px;">
                    Tweet
                </button>
            </div>
            </form>
        </div>
    </div>
    {{-- tweet boxes --}}
    <div class="row" id="tweets" style="display:none; ">
        @for ($i = 0; $i < count($timeline); $i++)
            @if($timeline[$i]->timelineable_type == 'App\Tweet')
                <x-tweet-box :tweet="$timeline[$i]->timelineable" />
            @endif
            @if($timeline[$i]->timelineable_type == 'App\Retweet')
                @if($timeline[$i]->timelineable->body == NULL)
                    <x-retweet-box :retweet="$timeline[$i]->timelineable" />
                @endif
            @endif
    @endfor
    </div> 
@endsection

@section('right-content')
<div class="container pb-3">
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
                <x-user-box :user="$user" :followers="$followers"/>
            @endforeach

            <div class="col-lg-9" style="border-radius: 0 0 15px 15px;">
                <div class="container pt-2 pb-2 bg-light" style="border-radius: 0 0 15px 15px;">
                    <a href="/users" class="font-weight-bold">See more...</a>
                </div>
            </div>
        @endif
    </div>

    {{-- people you're following --}}
    @if(count($followingUsers) > 0)
        <div class="row">
            <div class="col-lg-9">
                <div class="container bg-light pt-2" style="border-radius: 15px 15px 0 0; border-bottom: 1px solid rgba(0,0,0,.25);">
                    <div class="h4 font-weight-bold">People you're following</div>
                </div>
            </div>

            {{-- user box --}}
            @foreach ($followingUsers as $user)
                <div class="col-lg-9">
                    <div class="container d-flex bg-light pt-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.25);">
                        <div>
                            <a href="/users/{{$user->id}}">
                                <img class="rounded-circle mr-2"
                                style="max-height: 50px" 
                                src="https://i.pravatar.cc/300?u={{$user->email}}" 
                                alt="profile_picture">
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="h6 font-weight-bold mr-2">
                                <a href="/users/{{$user->id}}">{{$user->name}}</a>
                            </span>
                            {{-- <span>{{$user->name}}</span> --}}
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
            <div class="col-lg-9" style="border-radius: 0 0 15px 15px;">
                <div class="container pt-2 pb-2 bg-light" style="border-radius: 0 0 15px 15px;">
                    <a href="/users/{{Auth::id()}}/following" class="font-weight-bold">See more...</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection