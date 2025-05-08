@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Body</th>
        <th scope="col">Image</th> <!-- Aggiunta colonna immagine -->
        <th scope="col">User</th>
        <th scope="col">Created at</th>
        <th scope="col">Updated at</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($notes as $note)
        <tr>
            <th scope="row">{{ $note->id }}</th>
            <td>{{ $note->title }}</td>
            <td>{{ $note->body }}</td>
            <td>
                @if ($note->image_url)
                <img src="{{ asset('storage/' . $note->image_url) }}" alt="Immagine nota" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 4px solid white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                @else
                    <span>Nessuna immagine</span>
                @endif
            </td>
            
            <td>{{ $note->user->name }}</td>
            <td>{{ $note->created_at }}</td>
            <td>{{ $note->updated_at }}</td>
            <td>
              <div class="d-flex justify-content-between">
                <a href="{{ route('notes.show',$note->id) }}" class="btn btn-primary">Mostra</a>
              </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between">
    <a href="{{ route('notes.create') }}" class="btn btn-primary">Create Note</a>
    <form action="{{ route('notes.index') }}" method="GET" class="form-inline">
    </form>
</div>

<br>

{{ $notes->links() }}

@endsection
