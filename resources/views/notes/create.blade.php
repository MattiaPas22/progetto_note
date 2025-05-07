@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Crea una nuova Nota</h2>

    <!-- Form di creazione della nota -->
    <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Testo</label>
            <textarea name="body" class="form-control" id="body" rows="4" required>{{ old('body') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="formfileLeg" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="formfileLeg">

        <button type="submit" class="btn btn-primary">Crea Nota</button>
    </form>

    <!-- Link per tornare alla lista delle note -->
    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Torna alla lista</a>
    </div>

</div>
@endsection
