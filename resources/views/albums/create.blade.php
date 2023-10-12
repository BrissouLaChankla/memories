@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center">Ajouter un album</h1>
        <form method="POST" action="{{ route('albums.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="h5 form-label">{{ __('Titre') }}</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-4">
                <label for="description" class="h5 form-label">{{ __('Description') }}</label>
                <textarea class="form-control basic" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="row">

                <div class="col-lg-6 mb-4">
                    <label for="type" class="h5 form-label">{{ __('Type de photos') }}</label>
                    <select class="form-select" name="type" aria-label="Default select example">
                        <option selected value="voyage">Voyage</option>
                        <option value="paysage">Paysage</option>
                        <option value="portrait">Portrait</option>
                        <option value="rue">Rue</option>
                        <option value="mode">Mode</option>
                        <option value="nature-morte">Nature morte</option>
                        <option value="sport">Sport</option>
                        <option value="animaliere">Animalière</option>
                        <option value="documentaire">Documentaire</option>
                        <option value="mariage">Mariage</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-4">
                    <label for="location" class="h5 form-label">{{ __('Emplacement📍') }}</label>

                    <input class="form-control" list="datalistOptions" id="location" name="location"
                        onkeyup="processChange()">
                    <datalist id="datalistOptions">

                    </datalist>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary mt-3">{{ __('Ajouter l\'album') }}</button>
            </div>
        </form>

    </div>

    @push('scripts')
        <script>
            function debounce(func, timeout = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout);
                };
            }

            function saveInput() {
                const value = document.querySelector('#location').value;
                if (!value) {
                    return null;
                }
                fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${value}&apiKey=fd075490490447cfae003e95b3a5e991`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.features)


                        let propositions = data.features.map(el => {
                            return {
                                address: el.properties.address_line1
                            }
                        })

                        let datalist = document.querySelector('#datalistOptions')

                        datalist.innerHTML = "";
                        for (let proposition of propositions) {
                            datalist.innerHTML += `<option value="${proposition.address}">`
                        }


                        console.log(propositions)
                    })
                    .catch(error => console.error('error', error));
            }
            const processChange = debounce(() => saveInput());


            document.querySelector('#location').addEventListener("focusout", () => {
                const value = document.querySelector('#location').value;

                fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${value}&apiKey=fd075490490447cfae003e95b3a5e991`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector("#latitude").value = data.features[0].geometry.coordinates[0]
                        document.querySelector("#longitude").value = data.features[0].geometry.coordinates[1]
                    })
                    .catch(error => console.error('error', error));
            });
        </script>
    @endpush
@endsection
