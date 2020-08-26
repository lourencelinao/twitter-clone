<div class="col-lg-12 pt-2 tweet-box" style="border-bottom: 1px solid rgba(0,0,0, .25); transform: rotate(0);">
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
                    <form action="/retweets" method="POST">
                        @csrf
                        <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                        <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                            <i class="fa fa-retweet fa-lg custom-text-color retweet"></i>
                        </button>
                    </form>
                </span>
                {{-- heart --}}
                <span class=""> 
                    @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id])->count() > 0)
                        <form action="/likes/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                            <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                <i class="fa fa-heart fa-lg custom-text-color heart" style="color: red;"> {{$tweet->likes->count()}}</i>
                            </button>
                        </form>
                        @else
                        <form action="/likes" method="POST">
                            @csrf
                            <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                            {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                            <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                <i class="fa fa-heart fa-lg custom-text-color heart"> {{$tweet->likes->count()}}</i>
                            </button>
                        </form>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

