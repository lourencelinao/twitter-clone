@include('layouts.app')
@section('middle-content')

<form action="/tweets" method="POST">
    @csrf
<div class="row pt-2 pb-2" style="border-bottom: 5px solid gray;">
    {{-- home --}}
    <div class="col-lg-12" style="border-bottom: 1px solid rgba(0,0,0, .25);">
        <div class="h3 font-weight-bold">Home</div>    
    </div>
    {{-- tweet box --}}
    <div class="col-lg-12 d-flex pt-2 pb-2">
        
        <a href="">
            <img class="rounded-circle mr-2"
            style="max-height: 60px" 
            src="https://i.pravatar.cc/300?u={{Auth::user()->email}}" 
            alt="profile_picture">
        </a>
        {{-- tweet input --}}
        <textarea class="form-control @error('tweet') is-invalid @enderror" name="tweet" 
        id="" rows="2" cols="2"
        placeholder="What's poppin?" style="border:none; border-bottom: 1px solid rgba(0,0,0, .25);">
        </textarea>
        
    </div>
    {{-- below tweet box --}}
        @error('tweet')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    <div class="ml-auto col-lg-11 d-flex justfy-content-end align-items-center">
        <div class="">
            <button class="btn custom-text-color">
                <i class="fa fa-image fa-2x"></i>
            </button>
        </div>
        <div class="ml-auto pt-2 pb-2">
            <button type="submit" class="btn custom-background-color text-white">Tweet</button>
        </div>
        </form>
    </div>
</div>
{{-- tweet boxes --}}
<div class="row">
    @foreach ($tweets as $tweet)
        <x-tweet-box :tweet="$tweet" />
    @endforeach
</div>

@endsection

@section('right-content')
<div class="col-lg-4 col-md-4 col-sm-4" style="border-left: 1px solid rgba(0,0,0, .25);">
    <div class="container">
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
                <x-user-box :user="$user" />
            @endforeach

            <div class="col-lg-9">
                <div class="container pt-2 pb-2 bg-light" style="border-radius: 0 0 `15px 15px;">
                    <a href="" class="font-weight-bold">See more...</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection