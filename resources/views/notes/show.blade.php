<div>
 @extends('layouts.app')

@section('content')
<table class="table">
<div class="container">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Body</th>
      <th scope="col">User</th>
      <th scope="col">Creata</th>
      <th scope="col">Aggiornata</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <th scope="row">{{$note->id}}</th>
      <td>{{ $note->title}} </td>
      <td>{{ $note->body}} </td>
      <td>{{ $note->user->name}} </td>
      <td>{{ $note->created_at }} </td>
      <td>{{ $note->updated_at}}</td>
    </tr>

  </tbody>
</div>
</table>

@endsection
</div>
