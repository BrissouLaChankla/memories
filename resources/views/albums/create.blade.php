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

        <div class="mb-4">
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

        <div class="text-end">
            <button type="submit" class="btn btn-primary mt-3">{{ __('Ajouter l\'album') }}</button>
        </div>
    </form>

</div>
   
@endsection
