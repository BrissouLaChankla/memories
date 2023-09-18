@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between pt-4 pb-5">
            <a href="{{ route('albums.show', ['album' => $album_slug]) }}" class="btn btn-primary">
                < Revenir à l'album</a>
                    <h1 class="text-center m-0">Ajoute tes photos</h1>
                    <div></div>
        </div>
        <div id="dropzone">
            <form method="POST"
                class="dropzone dropzone-default dropzone-primary dz-clickable bg-info bg-opacity-10 border border-info rounded border-3"
                style="border-style: dashed!important" action="{{ route('photos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="dropzone-msg dz-message needsclick">
                    <h3 class="dropzone-msg-title">Glisse/dépose tes photos ici.</h3>
                    <span class="dropzone-msg-desc">Je me charge du reste tkt (conversion/resize..)</span>
                </div>

                <input type="hidden" name="album_id" value="{{ $album_id }}">
            </form>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
            integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            Dropzone.autoDiscover = false;
            let myDropzone = new Dropzone(".dropzone");
       
        </script>
    @endpush
@endsection
