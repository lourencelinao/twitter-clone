@extends('layouts.app')
@section('middle-content')
<div class="row">
    {{-- top part --}}
    <div class="col-lg-12 pb-1" style="border-bottom: 1px solid rgba(0,0,0, .25);">
        <div class="d-flex align-items-center">
            <a href="/home">
                <i class="fa fa-arrow-left text-dark pt-2 mr-3"></i>
            </a>
            <div class="d-flex flex-column">
                <div class="h5 font-weight-bold pt-2">
                    {{$profile->name}}
                </div>
                @if($profile->id == Auth::id())
                    <div>{{$profile->likes->count()}} likes</div>
                    @else
                    <div>{{$profile->tweets->count()}} tweets</div>
                @endif
            </div>
        </div>
    </div>
    {{-- profile photos --}}
    <div class="col-lg-12 px-0">
        {{-- background image --}}
        <img type="button" class="img-fluid"
        style="max-height: 100%; max-width: 100%;" 
        src="https://loremflickr.com/g/1000/300/{{$profile->id}}" 
        alt="background_picture" data-toggle="modal" data-target=".bd-example-modal-xl">
    </div>
    {{-- user photo --}}
    <div class="col-lg-12 d-flex align-items-center user-show-photo ml-2">
        <img type="button" class="rounded-circle shadow-sm"
        style="max-height: 150px; border: 5px solid white;" 
        src="https://i.pravatar.cc/300?u={{$profile->email}}" 
        alt="profile_picture" data-toggle="modal" data-target=".bd-example-modal-sm">
        {{-- profile follow/unfollow --}}
        @if($profile->id != Auth::id())
            @if(Auth::user()->follows->contains($profile->id))
                <div class="mt-5 mr-2 pt-3 d-flex ml-auto text-dark">
                    <form action="/follows/delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user_id" value="{{$profile->id}}">
                        <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold unfollow">
                            <span>Following</span>
                        </button>
                    </form>
                </div>
                @else
                <div class="mt-5 pt-3 mr-2 d-flex ml-auto text-dark">
                    <form action="/follows" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$profile->id}}">
                        <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold">
                            Follow
                        </button>
                    </form>
                </div>
            @endif

            @else
            {{-- if auth profile --}}
            <div class="mt-5 mr-2 d-flex ml-auto text-dark">
                <button class="btn btn-md rounded-pill custom-background-color text-white font-weight-bold" data-toggle="modal" data-target="#exampleModalLong">
                    Edit Profile
                </button>
            </div>
        @endif
        {{-- <div class="d-flex justify-content-start">
            <div class="ml-auto text-dark">
                haha
            </div>
        </div> --}}
    </div>
    <div class="col-lg-12 adjust pb-2" >
        <span class="ml-2 font-weight-bold h3">{{$profile->name}}</span> <br>
        <span class="ml-2"><i class="fas fa-calendar-alt fa-lg custom-text-color mr-2"></i></span>Joined {{$profile->created_at->format('Y-m-d')}} <br>
        <span class="ml-2">{{$profile->description}}</span> <br>
        <span class="ml-2"><a href="/users/{{$profile->id}}/following" class="font-weight-bold">{{$profile->follows->count()}}</a></span> following
        <span class="ml-2"><a href="/users/{{$profile->id}}/followers" class="font-weight-bold">{{App\Follow::all()->where('following_user_id', $profile->id)->count()}}</a></span> followers
    </div>
    {{-- tab and pills --}}
    <div class="col-lg-12 adjust" style="border-bottom: 1px solid rgba(0,0,0, .25);" id="sub_nav">
        <nav class="navbar-light" id="sub_nav">
            <ul class="nav d-flex justify-content-between" id="pills-tab" role="tablist">
                <li class="nav-item active">
                  <a class="nav-link text-dark" id="pills-tweets-tab" data-toggle="pill" href="#pills-tweets" role="tab" aria-controls="pills-tweets" aria-selected="true">Tweets</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-dark" id="pills-tweetsandreplies-tab" data-toggle="pill" href="#pills-tweetsandreplies" role="tab" aria-controls="pills-tweetsandreplies" aria-selected="false">Tweets & Replies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="pills-likes-tab" data-toggle="pill" href="#pills-likes" role="tab" aria-controls="pills-likes" aria-selected="false">Likes</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-12 adjust">
        <div class="tab-content" id="pills-tabContent">
            {{-- tweets tab --}}
            <div class="tab-pane fade show active adjust" id="pills-tweets" role="tabpanel" aria-labelledby="pills-tweets-tab">
                @foreach ($tweets as $tweet)
                <div class="row adjust tweet-box" style="transform: rotate(0);">
                    <a href="/users/{{$tweet->user->id}}/tweet/{{$tweet->id}}" class="stretched-link"></a>
                    <div class="col-lg-12 pl-2 py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
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
                                <div class="d-flex">
                                    <span class="mr-5">
                                        <form action="">
                                            <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                                            </button>
                                        </form>
                                    </span>
                                    <span class="mr-5">
                                        <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                            <i class="fa fa-retweet fa-lg custom-text-color retweet"></i>
                                        </button >
                                    </span>
                                    <span class="">
                                        @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id])->count() > 0)
                                            <form action="/likes/delete" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color heart" style="color: red;"> {{($tweet->likes->count() > 0)? $tweet->likes->count(): ''}}</i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="/likes" method="POST">
                                                @csrf
                                                <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                                                {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color heart"> {{($tweet->likes->count() > 0)? $tweet->likes->count(): ''}}</i>
                                                </button>
                                            </form>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- tweets and replies tab--}}
            <div class="tab-pane fade" id="pills-tweetsandreplies" role="tabpanel" aria-labelledby="pills-profile-tab">
                @foreach ($tweets as $tweet)
                <div class="row adjust tweet-box" style="transform: rotate(0);">
                    <a href="/users/{{$tweet->user->id}}/tweet/{{$tweet->id}}" class="stretched-link"></a>
                    <div class="col-lg-12 pl-2 py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
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
                                    <span class="mr-5">
                                        <form action="">
                                            <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                                            </button>
                                        </form>
                                    </span>
                                    <span class="mr-5">
                                        <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                            <i class="fa fa-retweet fa-lg custom-text-color retweet"></i>
                                        </button >
                                    </span>
                                    <span class="">
                                        @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $tweet->id])->count() > 0)
                                            <form action="/likes/delete" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color heart" style="color: red;"> {{($tweet->likes->count() > 0)? $tweet->likes->count(): ''}}</i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="/likes" method="POST">
                                                @csrf
                                                <input type="hidden" name="tweet_id" value="{{$tweet->id}}">
                                                {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color heart"> {{($tweet->likes->count() > 0)? $tweet->likes->count(): ''}}</i>
                                                </button>
                                            </form>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="tab-pane fade" id="pills-likes" role="tabpanel" aria-labelledby="pills-contact-tab">
                @for ($i = count($likes)-1; $i >= 0; $i--)
                    <div class="row adjust tweet-box" style="transform: rotate(0);">
                        <a href="/users/{{$likes[$i]->likeable->user->id}}/tweet/{{$likes[$i]->likeable->id}}" class="stretched-link"></a>
                        <div class="col-lg-12 pl-2 py-2" style="border-bottom: 1px solid rgba(0,0,0, .25);">
                            <div class="d-flex">
                                <a href="/users/{{$likes[$i]->likeable->user->id}}" style="position: relative; z-index: 1;">
                                    <img class="rounded-circle mr-2"
                                    style="max-height: 60px" 
                                    src="https://i.pravatar.cc/300?u={{$likes[$i]->likeable->user->email}}" 
                                    alt="profile_picture">
                                </a>
                                <div class="col-lg-11">
                                    <div class="d-flex align-items-start">
                                        <span class="h6 font-weight-bold mr-2">
                                            <a href="/users/{{$likes[$i]->likeable->user->id}}" style="position: relative; z-index: 1;">
                                                {{$likes[$i]->likeable->user->name}}
                                            </a>
                                        </span>
                                        <span class="h6">
                                            {{Carbon\Carbon::createFromTimeStamp(strtotime($likes[$i]->likeable->created_at))->diffForHumans(null, true)}}
                                        </span>
                                    </div>
                                    <p class="justify-text">
                                        {{$likes[$i]->likeable->body}}
                                    </p>
                                    <div class="pb-2 d-flex">
                                        <span class="mr-5">
                                            <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                <i class="fa fa-comment fa-lg custom-text-color comment"></i>
                                            </button>
                                        </span>
                                        <span class="mr-5">
                                            <button class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                <i class="fa fa-retweet fa-lg custom-text-color retweet"></i>
                                            </button>
                                        </span>
                                        {{-- like --}}
                                        <span class="mr-5">
                                            @if(App\Like::where(['user_id' => Auth::id(), 'likeable_id' => $likes[$i]->likeable->id])->count() > 0)
                                            <form action="/likes/delete" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="tweet_id" value="{{$likes[$i]->likeable->id}}">
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color" style="color: red;"> {{$likes[$i]->likeable->likes->count()}}</i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="/likes" method="POST">
                                                @csrf
                                                <input type="hidden" name="tweet_id" value="{{$likes[$i]->likeable->id}}">
                                                {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                                                <button type="submit" class="btn btn-sm rounded-circle" style="position: relative; z-index: 1;">
                                                    <i class="fa fa-heart fa-lg custom-text-color"> {{$likes[$i]->likeable->likes->count()}}</i>
                                                </button>
                                            </form>
                                        @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

{{-- background picture modal--}}
<div class="modal fade bd-example-modal-xl " tabindex="-1" role="document" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="row">
            <div class="col-lg-12 py-0 px-0 d-flex justify-content-center">
                <img class="img-fluid"
                style="" 
                src="https://loremflickr.com/g/1000/300/{{$profile->id}}" 
                alt="background_picture">
            </div>
        </div>
    </div>
</div>

{{-- small modal --}}
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="row">
          <div class="col-lg-12">
            <img class="rounded-circle shadow-sm"
            style="" 
            src="https://i.pravatar.cc/300?u={{$profile->email}}" 
            alt="profile_picture">
          </div>
      </div>
    </div>
  </div>
@endsection

@section('right-content')
<div class="container pb-3">
    <div class="row">
        {{-- search --}}
        <div class="col-lg-9 form-group mt-1">
            <input type="text" class="form-control" placeholder="Search..." style="border-radius: 15px;">
        </div>

        <div class="col-lg-9">
            <div class="container bg-light pt-2" style="border-radius: 15px 15px 0 0; border-bottom: 1px solid rgba(0,0,0,.25);">
                <div class="h4 font-weight-bold">Who to follow</div>
            </div>
        </div>

        {{-- user box --}}
        @foreach ($users as $user)
            <x-user-box :user="$user" :followers="$followers"/>
        @endforeach

        <div class="col-lg-9" style="border-radius: 0 0 15px 15px;">
            <div class="container pt-2 pb-2 bg-light" style="border-radius: 0 0 15px 15px;">
                <a href="/users" class="font-weight-bold">See more...</a>
            </div>
        </div>
    </div>
</div>  
@endsection

<!-- Edit profile -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <form action="/users/{{$profile->id}}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- name --}}
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label">Name</label>
      
                          <div class="col-md-12">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $profile->name }}" autocomplete="name" autofocus>
      
                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      {{-- description --}}
                      <div class="form-group row">
                          <label for="description" class="col-md-4 col-form-label">Description</label>
      
                          <div class="col-md-12">
                              <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $profile->description }}" autocomplete="description" autofocus>
      
                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
    </form>
</div>