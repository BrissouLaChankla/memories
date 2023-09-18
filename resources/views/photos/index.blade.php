@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Sélectionnez un album :</h1>
            <a href="{{ route('albums.create') }}"
                class="btn btn-primary btn-lg"
                >
                Ajouter un album
            </a>
        </div>
      
        @forelse($albums as $album)
            <p>{{ $album }}</p>
        @empty
            <p>Il n'y a aucun album pour le moment.</p>
        @endforelse
    </div>
@endsection
