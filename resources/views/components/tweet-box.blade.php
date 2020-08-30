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
                          @if($tweet->user->id == Auth::id())
                            <form action="/tweets/{{$tweet->id}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item">Delete</button>
                            </form>
                            @else
                                <form action="/follows/delete" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="user_id" value="{{$tweet->user->id}}">
                                    <button class="dropdown-item">Unfollow {{$tweet->user->name}}</button>
                                </form>
                          @endif
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
                    <a href="" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                        <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                    </a>
                </span>
                {{-- retweet --}}
                <span class="mr-5" >
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
                    @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id])->count() > 0)
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