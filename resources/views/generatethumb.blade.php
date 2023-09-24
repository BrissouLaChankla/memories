@extends('layouts.app')

@section('content')
    <div>

        @foreach ($videos as $videoname => $album_name)
        {{-- @dd($key) --}}
            <video preload="auto" data-album="{{$album_name}}"  data-photo="{{$videoname}}">
                <source src="{{ asset('storage/images/'.$album_name.'/' . $videoname) }}" type="video/mp4">
            </video>
        @endforeach

        <img id="lecteurIcone" class="d-none" src="{{ asset('player.png') }}" alt="Icône du lecteur">

    </div>

    @push('styles')
        <style>
            img {
                object-fit: cover;

            }
        </style>
    @endpush
    @push('scripts')
        <script>
            // Attendez que le document soit prêt
            document.addEventListener('DOMContentLoaded', function() {

                // Sélectionnez toutes les vidéos sur la page

                var videos = document.querySelectorAll('video');

                // Sélectionnez l'élément d'icône du lecteur
                var lecteurIcone = document.getElementById('lecteurIcone');

                // Définissez la hauteur souhaitée pour les miniatures
                var miniatureHeight = 300; // Hauteur en pixels

                // Parcourez chaque vidéo
                for (const video of videos) {
                    // Attendez que la vidéo soit chargée
                    video.addEventListener('loadeddata', function(e) {
                        // Calculez la largeur en fonction du ratio original de la vidéo
                        var aspectRatio = video.videoWidth / video.videoHeight;
                        var miniatureWidth = Math.round(miniatureHeight * aspectRatio);

                        // Créez un canvas avec les dimensions calculées
                        var canvas = document.createElement('canvas');
                        canvas.width = miniatureWidth;
                        canvas.height = miniatureHeight;
                        var context = canvas.getContext('2d');

                        // Capturez l'image à partir de la vidéo et dessinez-la sur le canvas
                        context.drawImage(video, 0, 0, miniatureWidth, miniatureHeight);

                        // Dessinez l'icône du lecteur sur le canvas
                        context.drawImage(lecteurIcone, 170, 70, 150,
                            150); // Les valeurs sont des coordonnées et dimensions d'exemple

                        // Convertissez le canvas en une image de données au format base64
                        var imageURI = canvas.toDataURL().split(';base64,')[1];

                        let album = e.target.getAttribute('data-album')
                        let photo = e.target.getAttribute('data-photo')

                       let data = { 
                        album_name : album,
                        photo_name:photo,
                        img:imageURI }

                        fetch('/postThumbs', {
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                                },
                                method: "POST",
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                // location.reload();
                            })


                        // Créez un élément d'image pour afficher la miniature
                        // var miniatureElement = document.createElement('img');
                        // miniatureElement.src = imageURI;

                        // // Ajoutez l'élément d'image à côté de la vidéo
                        // video.parentNode.insertBefore(miniatureElement, video.nextSibling);
                    });
                }



            });
        </script>
    @endpush
@endsection
