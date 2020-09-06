<div class="col-lg-12 pt-2 tweet-box" style="border-bottom: 1px solid rgba(0,0,0, .25); ">
    @if($retweet->retweetable_type == 'App\Tweet')
        <a href="/users/{{$retweet->retweetable->user->id}}/tweet/{{$retweet->retweetable->id}}" class="stretched-link"></a>
        @else
    @endif
    <span>
        <i class="fa fa-retweet fa-sm mr-2 ml-5"></i>
        @if($retweet->user_id == Auth::id())
            <a href="/users/{{Auth::id()}}" style="position: relative; z-index: 1;" class="text-secondary ml-1">
                You retweeted
            </a>
            @else
            <a href="/users/{{$retweet->user_id}}" style="position: relative; z-index: 1;" class="text-secondary ml-2">
                {{$retweet->user->name}} retweeted
            </a>
        @endif
    </span>
    <div class="d-flex">
        <a href="/users/{{$retweet->retweetable->user->id}}" style="position: relative; z-index: 1;">
            <img class="rounded-circle mr-2"
            style="max-height: 60px" 
            src="https://i.pravatar.cc/300?u={{$retweet->retweetable->user->email}}" 
            alt="profile_picture">
        </a>
        <div class="col-lg-11">
            <div class="d-flex align-items-start">
                <span class="h6 font-weight-bold mr-2">
                    <a href="/users/{{$retweet->retweetable->user->id}}" style="position: relative; z-index: 1;">
                        {{$retweet->retweetable->user->name}}
                    </a>
                </span>
                <span class="h6">
                    {{Carbon\Carbon::createFromTimeStamp(strtotime($retweet->retweetable->created_at))->diffForHumans(null, true)}}
                </span>
                <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn rounded-circle btn-sm chevron-down" type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                        aria-haspopup="true" aria-expanded="false" style="position: relative; z-index: 1;">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- if the owner of the tweet --}}
                            @if($retweet->retweetable->user->id == Auth::id())
                                <form action="/comments/{{$retweet->retweetable->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item">Delete</button>
                                </form>
                                @else
                                    {{-- if followed --}}
                                    @if(App\Follow::where(['user_id' => Auth::id(), 'following_user_id' => $retweet->retweetable->user_id])->count() > 0)
                                        <form action="/follows/delete" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="user_id" value="{{$retweet->retweetable->user_id}}">
                                            <button class="dropdown-item">Unfollow {{$retweet->retweetable->user->name}}</button>
                                        </form>
                                        {{-- if not followed --}}
                                        @else
                                        <form action="/follows" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{$retweet->retweetable->user_id}}">
                                            <button class="dropdown-item">Follow {{$retweet->retweetable->user->name}}</button>
                                        </form>
                                    @endif      
                            @endif
                            {{-- if not the owner of the tweet --}}
                        </div>
                    </div>
                </div>
            </div>
            <p class="justify-text">
                {{$retweet->retweetable->body}}
            </p>
            <div class="pb-2 d-flex">
                {{-- comment --}}
                <span class="mr-5">
                    <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;"
                    data-toggle="modal" data-target="#comment-retweet{{$retweet->retweetable_id}}">
                    <i class="fa fa-comment fa-lg custom-text-color comment">
                        {{($retweet->retweetable->comments->count() != 0)? $retweet->retweetable->comments->count(): ''}}
                    </i>
                    </button>
                    <!-- Modal --> 
                    {{-- make every modal unique so that it wont stick to one tweet box --}}
                    <div class="modal fade" id="comment-retweet{{$retweet->retweetable_id}}" tabindex="-1" role="dialog" aria-labelledby="comment-retweet{{$retweet->retweetable_id}}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/comments/tweet" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="d-flex">
                                            <img class="rounded-circle"
                                                style="max-height: 60px" 
                                                src="https://i.pravatar.cc/300?u={{$retweet->retweetable->user->email}}" 
                                                alt="profile_picture">
                                            <div class="col-11">
                                                <div class="d-flex align-items-start">
                                                    <span class="h6 font-weight-bold mr-2">
                                                        {{$retweet->retweetable->user->name}}
                                                    </span>
                                                    <span class="h6">
                                                        {{Carbon\Carbon::createFromTimeStamp(strtotime($retweet->retweetable->created_at))->diffForHumans(null, true)}}
                                                    </span>
                                                </div>
                                                <p class="justify-text">
                                                    {{$retweet->retweetable->body}}
                                                </p>
                                                <div class="text-secondary">
                                                    Replying to {{$retweet->retweetable->user->name}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <img class="rounded-circle"
                                                style="max-height: 60px" 
                                                src="https://i.pravatar.cc/300?u={{Auth::user()->email}}" 
                                                alt="profile_picture">
                                            <input type="hidden" name="tweet_id" value="{{$retweet->retweetable->id}}">
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
                </span>
                {{-- retweet --}}
                <span class="mr-5 {{($retweet->retweetable->comments->count() == 0)? 'ml-3': ''}}">
                    <div class="btn-group">
                        @if($retweet->retweetable_type == 'App\Tweet')
                            {{-- if auth user retweeted the tweet --}}
                            @if(App\Retweet::where([
                                'user_id' => Auth::id(),
                                'retweetable_id' => $retweet->retweetable->id,
                                'retweetable_type' => 'App\Tweet'
                                ])->count() > 0)
                                <button type="submit" class="btn btn-sm rounded-circle" 
                                style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1" style="color: green;">
                                            {{App\Retweet::where([
                                                'retweetable_id' => $retweet->retweetable_id,
                                                'retweetable_type' => 'App\Tweet'
                                                ])->count()}}
                                        </i>
                                    </div>
                                </button>
                                {{-- if not --}}
                                @else 
                                <button type="submit" class="btn btn-sm rounded-circle" 
                                style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1">
                                            {{App\Retweet::where([
                                                'retweetable_id' => $retweet->retweetable_id,
                                                'retweetable_type' => 'App\Tweet'
                                                ])->count()}}
                                        </i>
                                    </div>
                                </button>
                                    
                            @endif

                            @else
                                {{-- if auth user retweeted a comment --}}
                                @if(App\Retweet::where([
                                    'user_id' => Auth::id(),
                                    'retweetable_id' => $retweet->retweetable->id,
                                    'retweetable_type' => 'App\Comment'
                                    ])->count() > 0)
                                    <button type="submit" class="btn btn-sm rounded-circle" 
                                    style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1" style="color: green;">
                                                {{App\Retweet::where([
                                                    'retweetable_id' => $retweet->retweetable_id,
                                                    'retweetable_type' => 'App\Comment'
                                                    ])->count()}}
                                            </i>
                                        </div>
                                    </button>
                                    {{-- if not --}}
                                    @else 
                                    <button type="submit" class="btn btn-sm rounded-circle" 
                                    style="position: relative; z-index: 1;" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1">
                                                {{App\Retweet::where([
                                                    'retweetable_id' => $retweet->retweetable_id,
                                                    'retweetable_type' => 'App\Comment'
                                                    ])->count()}}
                                            </i>
                                        </div>
                                    </button>
                                        
                                @endif
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" style="position: relative; z-index: 1000;">
                            {{-- if user did not retweet the tweet--}}
                            @if(App\Retweet::where(['user_id' => Auth::id(),
                            'retweetable_id' => $retweet->retweetable_id])->count() == 0)
                                <form action="/retweets" method="POST">
                                    @csrf
                                    <input type="hidden" name="tweet_id" value="{{$retweet->retweetable->id}}">
                                    <button class="dropdown-item" type="submit">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-retweet mr-3"></i>
                                            <span>Retweet</span>
                                        </div>
                                    </button>
                                </form>   
                                @else
                                <form action="/retweets/{{$retweet->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item" type="submit">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-retweet mr-3"></i>
                                            <span>Undo Retweet</span>
                                        </div>
                                    </button>
                                </form>                
                            @endif
                        </div>

                    </div>
                </span>
                {{-- heart --}}
                <span class=""> 
                    @if($retweet->retweetable_type == 'App\Tweet')
                        @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $retweet->retweetable->id, 'likeable_type' => 'App\Tweet'])->count() > 0)
                            <form action="/likes/delete" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tweet_id" value="{{$retweet->retweetable->id}}">
                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                    <div class="d-flex align-items-center" class="heart">
                                        <i class="fa fa-heart fa-lg custom-text-color heart mr-1" style="color: red;">
                                            {{$retweet->retweetable->likes->count()}}
                                        </i>
                                    </div>
                                </button>
                            </form>
                            @else
                                <form action="/likes" method="POST">
                                    @csrf
                                    <input type="hidden" name="tweet_id" value="{{$retweet->retweetable->id}}">
                                    {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                    <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                        <div class="d-flex align-items-center" class="heart">
                                            <i class="fa fa-heart fa-lg custom-text-color heart mr-1">
                                                {{($retweet->retweetable->likes->count() > 0)? $retweet->retweetable->likes->count(): ''}}
                                            </i>
                                        </div>
                                    </button>
                                </form>
                        @endif

                        @else
                            @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $retweet->retweetable->id, 'likeable_type' => 'App\Comment'])->count() > 0)
                                <form action="/comments/likes/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="comment_id" value="{{$retweet->retweetable->id}}">
                                    <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                        <div class="d-flex align-items-center" class="heart">
                                            <i class="fa fa-heart fa-lg custom-text-color heart mr-1" style="color: red;">
                                                {{$retweet->retweetable->likes->count()}}
                                            </i>
                                        </div>
                                    </button>
                                </form>
                                @else
                                    <form action="/comments/likes" method="POST">
                                        @csrf
                                        <input type="hidden" name="comment_id" value="{{$retweet->retweetable->id}}">
                                        {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                        <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                            <div class="d-flex align-items-center" class="heart">
                                                <i class="fa fa-heart fa-lg custom-text-color heart mr-1">
                                                    {{($retweet->retweetable->likes->count() > 0)? $retweet->retweetable->likes->count(): ''}}
                                                </i>
                                            </div>
                                        </button>
                                    </form>
                            @endif
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>