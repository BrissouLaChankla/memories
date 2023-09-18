@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="bg-white p-3 p-md-5 shadow-sm mb-4 position-relative">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="m-0">{{$album->title}}</h1>
                        <a href="{{route('photos.create', ["album_id" => $album->id])}}" class="btn btn-primary btn-sm">Ajouter des photos</a>
                    </div>
                    <div class="py-4">
                        <small class="text-muted mt-3 text-capitalize">{{$album->type}}</small>
                        <p>
                            <span class="text-primary">
                                {{$album->authorname}}
                            </span>
                            - {{$album->description}}
                        </p>
                    </div>
                    <small class="share position-absolute end-0 bottom-0 py-2 px-3 d-flex align-items-center bg-primary bg-opacity-10" style="cursor: pointer; border-top-left-radius:.3rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#ea4e4e" stroke="#ea4e4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                        <span class="ms-2">
                            Partager l'album
                        </span>
                    </small>
                </div>
            </div>
        </div>
        <div id="animated-thumbnails-gallery">
            @forelse ($album->photos as $photo)
            {{-- data-lg-size="1920-1280" --}}

                <a href="{{ asset('storage/images/'.$album->slug.'/'. $photo->url) }}"  class="gallery-item text-decoration-none"
                    data-sub-html="<h4>Postée par - {{$photo->authorname}} </h4><p> Le {{$photo->created_at->format('d/m/Y')}} </p>"
                    >
                    <img src="{{ asset('storage/images/' .$album->slug.'/thumb/'. $photo->url) }}" 
                    
                    />
                </a>
                @empty
                <div class="alert alert-info mt-4" role="alert">
                    Il ne tarde que vous d'ajouter des photos à cet album 😉
                </div>
                @endforelse
            </div>
        </div>
    </div>



    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery-bundle.min.css" integrity="sha512-nUqPe0+ak577sKSMThGcKJauRI7ENhKC2FQAOOmdyCYSrUh0GnwLsZNYqwilpMmplN+3nO3zso8CWUgu33BDag==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lg-rotate.min.css" integrity="sha512-MA+4qtM9bL1Zo9WFrgpG5Du64wrIITpmGBgbGdxUhq2BOh5FT288I8vk6HD3qlRe3ld7kTYWbUxPBZ6BX+Paag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js" integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/zoom/lg-zoom.min.js" integrity="sha512-BfC/MaayF9sOZyn1bs1R1P8dEugU7v0j5Qu2FeWVfF/rhKUKZBD9kgNqRNinefIp9zAE7g2KhlwwhMpl5V1jMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/thumbnail/lg-thumbnail.min.js" integrity="sha512-Jx+orEb1KJtJ6Ajfshhr7is0zqgUC7H9ylk76KMtB9Ea2WAf/Muyzpe9zvBAYQQQKdAbj+rNYEorsRQLsmRafA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
         lightGallery(document.getElementById('animated-thumbnails-gallery'), {
            thumbnail: true,
                plugins: [lgZoom, lgThumbnail],
                speed: 500,
                
                // ... other settings
            });
            
            document.addEventListener("DOMContentLoaded", () => {


                const shareData = {
                    title: 'Memories',
                    text: 'Regarde cet album!',
                    url: '{{url()->full()}}',
                    }

                   
                    document.querySelector('.share').addEventListener('click', async () => {
                        try {
                            await navigator.share(shareData)
                        } catch(err) {
                            console.log('Error: ' + err)
                        }
                    });
                });

    </script>
    @endpush
@endsection
