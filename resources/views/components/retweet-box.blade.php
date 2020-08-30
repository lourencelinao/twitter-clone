<div class="col-lg-12 pt-2 tweet-box" style="border-bottom: 1px solid rgba(0,0,0, .25); ">
    <a href="/users/{{$retweet->retweetable->user->id}}/tweet/{{$retweet->retweetable->id}}" class="stretched-link"></a>
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
                          @if($retweet->retweetable->user->id == Auth::id())
                            <form action="/retweets/{{$retweet->id}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item">Delete</button>
                            </form>
                            @else
                                <form action="/follows/delete" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="user_id" value="{{$retweet->retweetable->user->id}}">
                                    <button class="dropdown-item">Unfollow {{$retweet->retweetable->user->name}}</button>
                                </form>
                          @endif
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
                    <a href="" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                        <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                    </a>
                </span>
                {{-- retweet --}}
                <span class="mr-5" >
                    <div class="btn-group">
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
                    @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $retweet->retweetable->id])->count() > 0)
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
                </span>
            </div>
        </div>
    </div>
</div>