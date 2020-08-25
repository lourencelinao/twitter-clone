<div class="col-lg-12 pt-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
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