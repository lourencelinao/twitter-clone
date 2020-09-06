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
    <div class="ml-auto mr-2">
        <div class="dropdown">
            <button class="btn rounded-circle btn-sm chevron-down" type="button" id="dropdownMenuButton" data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false" style="position: relative; z-index: 1;">
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {{-- if the owner of the tweet --}}
                @if($tweet->user->id == Auth::id())
                    <form action="/tweets/{{$tweet->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="dropdown-item">Delete</button>
                    </form>
                    @else
                        {{-- if followed --}}
                        @if(App\Follow::where(['user_id' => Auth::id(), 'following_user_id' => $tweet->user_id])->count() > 0)
                            <form action="/follows/delete" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="user_id" value="{{$tweet->user_id}}">
                                <button class="dropdown-item">Unfollow {{$tweet->user->name}}</button>
                            </form>
                            {{-- if not followed --}}
                            @else
                            <form action="/follows" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$tweet->user_id}}">
                                <button class="dropdown-item">Follow {{$tweet->user->name}}</button>
                            </form>
                        @endif      
                @endif
                {{-- if not the owner of the tweet --}}
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
<div class="row">
    @foreach ($comments as $comment)
    <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
        <div class="d-flex py-2">
            <a href="/users/{{$comment->user_id}}" style="position: relative; z-index: 1;">
                <img class="rounded-circle mr-2"
                style="max-height: 60px" 
                src="https://i.pravatar.cc/300?u={{$comment->user->email}}" 
                alt="profile_picture">
            </a>
            <div class="col-lg-11">
                <div class="d-flex align-items-baseline">
                    <span class="h6 font-weight-bold mr-2">
                        <a href="/users/{{$comment->user_id}}" style="position: relative; z-index: 1;">
                            {{$comment->user->name}}
                        </a>
                    </span>
                    <span>
                        {{Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans(null, true)}}
                    </span>
                    <div class="ml-auto">
                        <div class="dropdown">
                            <button class="btn rounded-circle btn-sm chevron-down" type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false" style="position: relative; z-index: 1;">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                {{-- if the owner of the tweet --}}
                                @if($comment->user->id == Auth::id())
                                    <form action="/comments/{{$comment->id}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item">Delete</button>
                                    </form>
                                    @else
                                        {{-- if followed --}}
                                        @if(App\Follow::where(['user_id' => Auth::id(), 'following_user_id' => $comment->user_id])->count() > 0)
                                            <form action="/follows/delete" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="user_id" value="{{$comment->user_id}}">
                                                <button class="dropdown-item">Unfollow {{$comment->user->name}}</button>
                                            </form>
                                            {{-- if not followed --}}
                                            @else
                                            <form action="/follows" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{$comment->user_id}}">
                                                <button class="dropdown-item">Follow {{$comment->user->name}}</button>
                                            </form>
                                        @endif      
                                @endif
                                {{-- if not the owner of the tweet --}}
                            </div>
                          </div>
                    </div>
                </div>
                <p class="text-justify">
                    {{$comment->body}}
                </p>
                <div class="pb-2 d-flex">
                    {{-- comment --}}
                    <span class="mr-5">
                        <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;"
                        data-toggle="modal" data-target="#comment{{$comment->id}}">
                        <i class="fa fa-comment fa-lg custom-text-color comment"> 
                            {{($comment->comments->count() > 0)? $comment->comments->count(): ''}}
                        </i>
                        </button>
                        <!-- Modal --> 
                        {{-- make every modal unique so that it wont stick to one tweet box --}}
                        <div class="modal fade" id="comment{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="comment{{$comment->id}}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Comment
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/comments/comment" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="d-flex">
                                                    <img class="rounded-circle"
                                                        style="max-height: 60px" 
                                                        src="https://i.pravatar.cc/300?u={{$comment->user->email}}" 
                                                        alt="profile_picture">
                                                    <div class="col-11">
                                                        <div class="d-flex align-items-start">
                                                            <span class="h6 font-weight-bold mr-2">
                                                                {{$comment->user->name}}
                                                            </span>
                                                            <span class="h6">
                                                                {{Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans(null, true)}}
                                                            </span>
                                                        </div>
                                                        <p class="justify-text">
                                                            {{$comment->body}}
                                                        </p>
                                                        <div class="text-secondary">
                                                            Replying to {{$comment->user->name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-3">
                                                    <img class="rounded-circle"
                                                        style="max-height: 60px" 
                                                        src="https://i.pravatar.cc/300?u={{Auth::user()->email}}" 
                                                        alt="profile_picture">
                                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                    <textarea class="form-control @error('reply') is-invalid @enderror ml-1" name="reply" 
                                                    id="" rows="2" cols="2"
                                                    placeholder="Tweet your reply" style="border: none;">
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn custom-background-color text-white rounded-pill" id="replyTweetBtn">
                                                    Reply
                                                </button>
                                            </div>
                                        </form>                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>
                    {{-- retweet --}}
                    <span class="mr-5" >
                        <div class="btn-group">
                            {{-- if more than one retweet --}}
                            @if(App\Retweet::where([
                                'user_id' => Auth::id(),
                                'retweetable_id' => $comment->id,
                                'retweetable_type' => 'App\Comment'
                                ])->count() > 0)
                                <button type="submit" class="btn btn-sm rounded-circle" 
                                style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1" style="color: green;">
                                        {{App\Retweet::where([
                                            'retweetable_id' => $comment->id,
                                            'retweetable_type' => 'App\Comment'
                                            ])->count()}}
                                    </i>
                                </button>
                                @else
                                <button type="submit" class="btn btn-sm rounded-circle" 
                                style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-retweet fa-lg custom-text-color retweet mr-3">
                                        {{(App\Retweet::where([
                                            'retweetable_id' => $comment->id,
                                            'retweetable_type' => 'App\Comment'
                                            ])->count() > 0)? App\Retweet::where([
                                            'retweetable_id' => $comment->id,
                                            'retweetable_type' => 'App\Comment'
                                            ])->count() : ''}}
                                    </i>
                                </button>
                            @endif
                            <div class="dropdown-menu dropdown-menu-right" style="position: relative; z-index: 1000;">
                                {{-- if more than one retweet --}}
                                @if(App\Retweet::where([
                                    'user_id' => Auth::id(),
                                    'retweetable_id' => $comment->id,
                                    'retweetable_type' => 'App\Comment'
                                    ])->count() > 0)
                                    <form action="/retweets/{{App\Retweet::where([
                                        'user_id' => Auth::id(),
                                        'retweetable_id' => $comment->id,
                                        'retweetable_type' => 'App\Comment'
                                    ])->pluck('id')->get(0)}}" 
                                    method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                        <button class="dropdown-item" type="submit">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-retweet mr-3"></i>
                                                <span>Undo Retweet</span>
                                            </div>
                                        </button>
                                    </form>
                                    @else
                                    <form action="/retweets/comment" method="POST">
                                        @csrf
                                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                        <button class="dropdown-item" type="submit">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-retweet mr-3"></i>
                                                <span>Retweet</span>
                                            </div>
                                        </button>
                                    </form>
                                @endif
                            </div>
    
                        </div>
                    </span>
                    {{-- heart --}}
                    <span class=""> 
                        @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $comment->id, 'likeable_type' => 'App\Comment'])->count() > 0)
                            <form action="/comments/likes/delete" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                    <i class="fa fa-heart fa-lg custom-text-color heart mr-1" style="color: red;"> {{$comment->likes->count()}}</i>
                                </button>
                            </form>
                            @else
                            <form action="/comments/likes" method="POST" onsubmit="heartBtn.disabled = true; return true;">
                                @csrf
                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                <button type="submit" class="btn btn-sm rounded-circle" 
                                style="position: relative; z-index: 1;" id="heartBtn">
                                    <i class="fa fa-heart fa-lg custom-text-color heart mr-1"> 
                                        {{($comment->likes->count() > 0)? $comment->likes->count(): ''}}
                                    </i>
                                </button>
                            </form>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('right-content')
    
@endsection