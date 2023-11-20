@extends('layouts.app')

@section('content')
    <header class="text-center text-white d-flex align-items-center justify-content-center album-header flex-column">
        <h1>Albums</h1>
        <p>❤️ Tous nos albums photos ❤️</p>
    </header>
    <div class="container-fluid">
        <div class="row p-4 g-4">
            @forelse ($albums as $album)
            @if(!Auth::user()->access || $album->id == Auth::user()->access)
                <div class="col-md-3 col-sm-6">
                    @if ($album->cover)
                        <a href="{{ route('albums.show', ['album' => $album->slug]) }}"
                            class="text-decoration-none position-relative d-flex flex-column text-center justify-content-center text-white album-card"
                            style=" background-image:
                    linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                    
                    url('{{ asset('storage/images/' . $album->slug . '/thumb/' . $album->cover) }}')">
                        @else
                            <a href="{{ route('albums.show', ['album' => $album->slug]) }}"
                                class="text-decoration-none position-relative d-flex flex-column text-center justify-content-center text-white album-card"
                                style=" background-image:
                    linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                    url('https://placehold.co/600x400?text=VIDE')">
                    @endif
                    <span class="bg-dark bg-opacity-50 position-absolute end-0 bottom-0 py-1 px-2 d-flex align-items-center" style="border-top-left-radius: .3rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span class="ms-2">
                            {{$album->photos->count()}}
                        </span>
                    </span>
                    <h4 class="text-uppercase text-white">{{ $album->title }}</h4>
                    <small class="text-primary text-capitalize">{{ $album->type }}</small>
                    </a>
                </div>
                @endif
            @empty
                <div class="alert alert-primary" role="alert">
                    Patience, il n'y a pas encore d'album photo !
                </div>
            @endforelse
        </div>
    </div>
@endsection
