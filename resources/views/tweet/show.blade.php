@extends('layouts.app')
@section('middle-content')
<div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
    {{-- home --}}
    <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
        <div class="d-flex">
            <a href="/home">
                <i class="fa fa-arrow-left text-dark pt-2 mr-3"></i>
            </a>
            <div class="h3 font-weight-bold">Tweet</div>       
        </div>  
    </div>

    {{-- name --}}
    <div class="d-flex py-2 pl-2">
        <a href="/users/{{$user->id}}" style="position: relative; z-index: 1;">
            <img class="rounded-circle mr-2"
            style="max-height: 60px" 
            src="https://i.pravatar.cc/300?u={{$user->email}}" 
            alt="profile_picture">
        </a>
        <div class="col-lg-11 p-0">
            <div class="d-flex align-items-start">
                <span class="h6 font-weight-bold mr-2">
                    <a href="/users/{{$user->id}}" style="position: relative; z-index: 1;">
                        {{$user->name}}
                    </a>
                </span>
            </div>
        </div>
    </div>

    {{-- tweet --}}
    <div class="col-lg-12">
        <span class="text-justify h3">
            {{$tweet->body}}
        </span>
    </div>
    {{-- time --}}
    <div class="col-lg-12">
        <span class="text-secondary">{{$tweet->created_at->format("h:i a")}}</span> 
        <span class="text-secondary">{{$tweet->created_at->format("M, d, Y")}}</span>
        <hr>
        {{-- only display retweets and comments if they are over 50 --}}
        {{-- <span class="font-weight-bold"><a href="" class="text-dark"> <span class="text-secondary mr-3">Retweets and comments</span></a> --}}
        @if($tweet->likes->count() > 0)
            <div class="font-weight-bold">
                <a href="" class="text-dark">{{$tweet->likes->count()}} 
                    @if($tweet->likes->count() > 1)
                        <span class="text-secondary">Likes</span>
                        @else
                        <span class="text-secondary">Like</span>
                    @endif
                </a>
            </div>
            <hr>
        @endif
        <div class="d-flex">
            <span class="mr-5">
                <form action="">
                    @csrf
                    <button type="submit" class="btn btn-md rounded-circle" style="position: relative; z-index: 1;">
                        <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                    </button>
                </form>
            </span>
            <span class="mr-5">
                <form action="">
                    @csrf
                    <button type="submit" class="btn btn-md rounded-circle" style="position: relative; z-index: 1;">
                        <i class="fa fa-retweet fa-lg custom-text-color retweet"></i>
                    </button>
                </form>
            </span>
            <span class=""> 
                @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id])->count() > 0)
                    <form action="/likes/delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                        <button type="submit" class="btn btn-md rounded-circle" style="position: relative; z-index: 1;">
                            <i class="fa fa-heart fa-lg custom-text-color heart" style="color: red;"> {{($tweet->likes->count() > 0) ? $tweet->likes->count() : ''}}</i>
                        </button>
                    </form>
                    @else
                    <form action="/likes" method="POST">
                        @csrf
                        <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                        {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                        <button type="submit" class="btn btn-md rounded-circle" style="position: relative; z-index: 1;">
                            <i class="fa fa-heart fa-lg custom-text-color heart"> {{($tweet->likes->count() > 0) ? $tweet->likes->count() : ''}}</i>
                        </button>
                    </form>
                @endif
            </span>
        </div>
    </div>
    
</div>
@endsection

@section('right-content')
    
@endsection