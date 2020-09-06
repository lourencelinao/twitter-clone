<div class="col-lg-12 pt-2 tweet-box" style="border-bottom: 1px solid rgba(0,0,0, .25); ">
    <a href="/users/{{$tweet->user->id}}/tweet/{{$tweet->id}}" class="stretched-link"></a>
    <div class="d-flex">
        <a href="/users/{{$tweet->user->id}}" style="position: relative; z-index: 1;">
            <img class="rounded-circle mr-2"
            style="max-height: 60px" 
            src="https://i.pravatar.cc/300?u={{$tweet->user->email}}" 
            alt="profile_picture">
        </a>
        <div class="col-lg-11">
            <div class="d-flex align-items-start">
                <span class="h6 font-weight-bold mr-2">
                    <a href="/users/{{$tweet->user->id}}" style="position: relative; z-index: 1;">
                        {{$tweet->user->name}}
                    </a>
                </span>
                <span class="h6">
                    {{Carbon\Carbon::createFromTimeStamp(strtotime($tweet->created_at))->diffForHumans(null, true)}}
                </span>
                <div class="ml-auto">
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
                                        <form action="/bitch">
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
            </div>
            <p class="justify-text">
                {{$tweet->body}}
            </p>
            <div class="pb-2 d-flex">
                {{-- comment --}}
                <span class="mr-5">
                    <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;"
                    data-toggle="modal" data-target="#tweet{{$tweet->id}}">
                    <i class="fa fa-comment fa-lg custom-text-color comment"> 
                        {{($tweet->comments->count() != 0)? $tweet->comments->count(): ''}}
                    </i>
                    </button>
                    <!-- Modal --> 
                    {{-- make every modal unique so that it wont stick to one tweet box --}}
                    <div class="modal fade" id="tweet{{$tweet->id}}" tabindex="-1" role="dialog" aria-labelledby="tweet{{$tweet->id}}Label" aria-hidden="true">
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
                                                src="https://i.pravatar.cc/300?u={{$tweet->user->email}}" 
                                                alt="profile_picture">
                                            <div class="col-11">
                                                <div class="d-flex align-items-start">
                                                    <span class="h6 font-weight-bold mr-2">
                                                        {{$tweet->user->name}}
                                                    </span>
                                                    <span class="h6">
                                                        {{Carbon\Carbon::createFromTimeStamp(strtotime($tweet->created_at))->diffForHumans(null, true)}}
                                                    </span>
                                                </div>
                                                <p class="justify-text">
                                                    {{$tweet->body}}
                                                </p>
                                                <div class="text-secondary">
                                                    Replying to {{$tweet->user->name}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <img class="rounded-circle"
                                                style="max-height: 60px" 
                                                src="https://i.pravatar.cc/300?u={{Auth::user()->email}}" 
                                                alt="profile_picture">
                                            <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
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
                <span class="mr-5 {{($tweet->comments->count() == 0)? 'ml-3': ''}}">
                    <div class="btn-group">
                        {{-- if more than one retweet --}}
                        @if(App\Retweet::where([
                            'user_id' => Auth::id(),
                            'retweetable_id' => $tweet->id,
                            'retweetable_type' => 'App\Tweet'
                            ])->count() > 0)
                            <button type="submit" class="btn btn-sm rounded-circle" 
                            style="position: relative; z-index: 1;" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-retweet fa-lg custom-text-color retweet mr-1" style="color: green;">
                                    {{$tweet->retweets->count()}}
                                </i>
                            </button>
                            @else
                            <button type="submit" class="btn btn-sm rounded-circle" 
                            style="position: relative; z-index: 1;" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-retweet fa-lg custom-text-color retweet mr-3">
                                    {{($tweet->retweets->count() > 0)? $tweet->retweets->count(): ''}}
                                </i>
                            </button>
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" style="position: relative; z-index: 1000;">
                            {{-- if more than one retweet --}}
                            @if(App\Retweet::where([
                                'user_id' => Auth::id(),
                                'retweetable_id' => $tweet->id,
                                'retweetable_type' => 'App\Tweet'
                                ])->count() > 0)
                                <form action="/retweets/{{App\Retweet::where([
                                    'user_id' => Auth::id(),
                                    'retweetable_id' => $tweet->id,
                                    'retweetable_type' => 'App\Tweet'
                                ])->pluck('id')->get(0)}}" 
                                method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                                    <button class="dropdown-item" type="submit">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-retweet mr-3"></i>
                                            <span>Undo Retweet</span>
                                        </div>
                                    </button>
                                </form>
                                @else
                                <form action="/retweets" method="POST">
                                    @csrf
                                    <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
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
                    @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id, 'likeable_type' => 'App\Tweet'])->count() > 0)
                        <form action="/likes/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                            <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                <i class="fa fa-heart fa-lg custom-text-color heart mr-1" style="color: red;"> {{$tweet->likes->count()}}</i>
                            </button>
                        </form>
                        @else
                        <form action="/likes" method="POST" onsubmit="heartBtn.disabled = true; return true;">
                            @csrf
                            <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                            {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                            <button type="submit" class="btn btn-sm rounded-circle" 
                            style="position: relative; z-index: 1;" id="heartBtn">
                                <i class="fa fa-heart fa-lg custom-text-color heart mr-1"> 
                                    {{($tweet->likes->count() > 0)? $tweet->likes->count(): ''}}
                                </i>
                            </button>
                        </form>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>