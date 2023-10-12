@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="bg-white p-3 p-md-5 shadow-sm mb-4 position-relative">
                    @if ($album->user_id === Auth::user()->id)
                        <span class="position-absolute top-0 start-0 bg-primary py-1 px-2 delete-album"
                            style="border-bottom-right-radius: .5rem; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </span>
                    @endif

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="m-0">{{ $album->title }}</h1>
                        <a href="{{ route('photos.create', ['album_id' => $album->id]) }}"
                            class="btn btn-info text-white btn-sm">Ajouter des photos</a>
                    </div>
                    <div class="py-4">
                        <small class="text-muted mt-3 text-capitalize">{{ $album->type }}</small>
                        <p>
                            <span class="text-primary">
                                {{ $album->authorname }}
                            </span>
                            - {{ $album->description }}
                        </p>
                    </div>
                    <a href="{{ route('albums.download', ['album' => $album->id]) }}"
                        class="download-album small text-decoration-none text-black position-absolute start-0 bottom-0 py-2 px-3 d-flex align-items-center bg-primary bg-opacity-10"
                        style="cursor: pointer; border-top-left-radius:.3rem">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ea4e4e" stroke-width="1.104">
                            <g id="SVGRepo_bgCarrier" stroke-width="0" />
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                                stroke-width="0.624" />
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12.5535 16.5061C12.4114 16.6615 12.2106 16.75 12 16.75C11.7894 16.75 11.5886 16.6615 11.4465 16.5061L7.44648 12.1311C7.16698 11.8254 7.18822 11.351 7.49392 11.0715C7.79963 10.792 8.27402 10.8132 8.55352 11.1189L11.25 14.0682V3C11.25 2.58579 11.5858 2.25 12 2.25C12.4142 2.25 12.75 2.58579 12.75 3V14.0682L15.4465 11.1189C15.726 10.8132 16.2004 10.792 16.5061 11.0715C16.8118 11.351 16.833 11.8254 16.5535 12.1311L12.5535 16.5061Z"
                                    fill="#ea4e4e" />
                                <path
                                    d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z"
                                    fill="#ea4e4e" />
                            </g>
                        </svg>
                        <span class="ms-2">
                            Télécharger l'album
                        </span>
                    </a>

                    <small
                        class="share position-absolute end-0 bottom-0 py-2 px-3 d-flex align-items-center bg-primary bg-opacity-10"
                        style="cursor: pointer; border-top-left-radius:.3rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="#ea4e4e" stroke="#ea4e4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-share-2">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                        <span class="ms-2">
                            Partager l'album
                        </span>
                    </small>
                </div>
            </div>
        </div>

        <div id="animated-thumbnails-gallery" class="text-center mt-3">
            @forelse ($album->photos as $photo)
                @if (pathinfo($photo->url)['extension'] === 'webp')
                    <a href="{{ asset('storage/images/' . $album->slug . '/' . $photo->url) }}"
                        class="gallery-item text-decoration-none  position-relative h-100 d-inline-block overflow-hidden"
                        data-sub-html="<h4>Postée par - {{ $photo->authorname }} </h4><p> Le {{ $photo->created_at->format('d/m/Y') }} </p>">

                        <img loading="lazy"
                            src="{{ asset('storage/images/' . $album->slug . '/thumb/' . pathinfo($photo->url)['filename'] . '.webp') }}" />

                    </a>
                @else
                    <a data-video='{"source": [{"src":"{{ asset('storage/images/' . $album->slug . '/' . $photo->url) }}", "type":"video/mp4"}], "attributes": {"preload": false, "controls": true}}'
                        class="gallery-item text-decoration-none  position-relative h-100 d-inline-block overflow-hidden"
                        data-poster="{{ asset('storage/images/' . $album->slug . '/thumb/' . pathinfo($photo->url)['filename'] . '.webp') }}"
                        data-sub-html="<h4>Postée par - {{ $photo->authorname }} </h4><p> Le {{ $photo->created_at->format('d/m/Y') }} </p>">
                        <img height="200" class="img-responsive"
                            src="{{ asset('storage/images/' . $album->slug . '/thumb/' . pathinfo($photo->url)['filename'] . '.webp') }}" />
                    </a>
                @endif

            @empty
                <div class="alert alert-info mt-4" role="alert">
                    Il ne tarde que vous d'ajouter des photos à cet album 😉
                </div>
            @endforelse
        </div>
    </div>
    </div>



    @push('styles')
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery-bundle.min.css"
            integrity="sha512-nUqPe0+ak577sKSMThGcKJauRI7ENhKC2FQAOOmdyCYSrUh0GnwLsZNYqwilpMmplN+3nO3zso8CWUgu33BDag=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lg-rotate.min.css"
            integrity="sha512-MA+4qtM9bL1Zo9WFrgpG5Du64wrIITpmGBgbGdxUhq2BOh5FT288I8vk6HD3qlRe3ld7kTYWbUxPBZ6BX+Paag=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush


    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"
            integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/zoom/lg-zoom.min.js"
            integrity="sha512-BfC/MaayF9sOZyn1bs1R1P8dEugU7v0j5Qu2FeWVfF/rhKUKZBD9kgNqRNinefIp9zAE7g2KhlwwhMpl5V1jMA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/thumbnail/lg-thumbnail.min.js"
            integrity="sha512-Jx+orEb1KJtJ6Ajfshhr7is0zqgUC7H9ylk76KMtB9Ea2WAf/Muyzpe9zvBAYQQQKdAbj+rNYEorsRQLsmRafA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/video/lg-video.min.js"
            integrity="sha512-mjdf6tU1Mksu9Hq2YXfbxdzzYHU7SJYmAsMnrhBf80SkHFvk6eHa2d79JM0q5w5ft5nQyBQ0EMB+XTmnvhcFgA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <script>
            lightGallery(document.getElementById('animated-thumbnails-gallery'), {
                thumbnail: true,
                plugins: [lgZoom, lgThumbnail, lgVideo],
                speed: 500,

                // ... other settings
            });

            function deletePhoto(e) {
                const fileToDel = e.parentNode.querySelector('#lg-download-1').href.split('/').at(-1);
                fetch('/photos/destroy?photo_name=' + fileToDel, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },
                        method: "DELETE",

                    })
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data);
                        location.reload();
                    })
            }

            document.addEventListener("DOMContentLoaded", () => {
                // Add delete button

                const toolBar = document.querySelector('#lg-toolbar-1');
                toolBar.insertAdjacentHTML("beforeend", `
        <span class="ms-2" style="cursor:pointer;" onclick="deletePhoto(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
            </path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg></span>
             
                `);






                document.querySelector('.delete-album').addEventListener('click', () => {
                    Swal.fire({
                        title: 'Attention !',
                        text: "Tu vas supprimer cet album et toutes les photos qu'il contient !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimer!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route('albums.destroy', ['album' => $album->id]) }}', {
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                                    },
                                    method: "DELETE",

                                })
                                .then(response => response.json())
                                .then(data => {

                                    window.location.href = "/";
                                })
                        }
                    })
                })


                const shareData = {
                    title: 'Memories - {{ $album->title }}',
                    text: '📷➡️ ',
                    url: '{{ url()->full() }}',
                }


                document.querySelector('.share').addEventListener('click', async () => {
                    try {
                        await navigator.share(shareData)
                    } catch (err) {
                        console.log('Error: ' + err)
                    }
                });

            });
        </script>
    @endpush
@endsection
