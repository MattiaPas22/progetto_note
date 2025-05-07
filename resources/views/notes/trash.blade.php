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
            <td>{{ $note->user->name }}</td>
            <td>{{ $note->created_at }}</td>
            <td>{{ $note->updated_at }}</td>
            <td>
              <div class="d-flex justify-content-between">
                <a href="{{ route('notes.restore',$note->id) }}" class="btn btn-primary">Restore</a>
                
            </div>
        </tr>
        @endforeach
    </tbody>
</table>



<br>

{{ $notes->links() }}

@endsection
