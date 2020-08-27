@extends('layouts.app')
@section('middle-content')
    <div class="row pt-2">
        <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
            <div class="h3 font-weight-bold">Followers</div>    
        </div>

        @foreach ($followers as $user)
        <div class="col-lg-12 pt-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
            <div class="container d-flex">

                <div>
                    <a href="/users/{{$user->id}}">
                        <img class="rounded-circle mr-2"
                        style="max-height: 50px" 
                        src="https://i.pravatar.cc/300?u={{$user->email}}" 
                        alt="profile_picture">
                    </a>
                </div>

                <div class="font-weight-bold">
                    <a href="/users/{{$user->id}}">
                        {{$user->name}}
                    </a>
                </div>

                <div class="ml-auto d-flex align-items-center side-follow-btn">
                    @if($user->id != Auth::id())
                        @if(Auth::user()->follows->contains($user->id))
                            <div class="mr-2 d-flex ml-auto text-dark">
                                <form action="/follows/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold unfollow">
                                        <span>Following</span>
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class=" mr-2 d-flex ml-auto text-dark">
                                <form action="/follows" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold">
                                        Follow
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('right-content')
    {{-- who to follow --}}
    
@endsection