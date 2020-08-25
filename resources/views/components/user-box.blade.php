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
            <form action="/follows" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <button class="btn font-weight-bold custom-text-color" style="border: 1px solid #1DA1F2; border-radius: 25px;">
                    Follow
                </button>
            </form>
        </div>
    </div>
</div>