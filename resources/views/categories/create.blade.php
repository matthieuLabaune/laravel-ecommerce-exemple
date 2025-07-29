@extends('layouts.app')

@section('title', 'Créer une Catégorie')
@section('header', 'Créer une Catégorie')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Nouvelle Catégorie</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Catégorie active</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Créer la catégorie</button>
            </div>
        </form>
    </div>
</div>
@endsection
