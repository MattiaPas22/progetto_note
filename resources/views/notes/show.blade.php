@extends('layouts.app')

@section('content')
<div class="container">

<!-- Immagine nota sopra la tabella -->
<div class="mb-4 text-center">
  @if ($note->image_url)
      <img src="{{ asset('storage/' . $note->image_url) }}" alt="Immagine nota" class="img-fluid rounded" style="max-width: 400px; height: auto;">
  @else
      <p>Nessuna immagine caricata.</p>
  @endif
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titolo</th>
      <th scope="col">Testo</th>
      <th scope="col">Utente</th>
      <th scope="col">Creata il</th>
      <th scope="col">Aggiornata il</th>
      <th scope="col">Azioni</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">{{ $note->id }}</th>
      <td>{{ $note->title }}</td>
      <td>{{ $note->body }}</td>
      <td>{{ $note->user->name }}</td>
      <td>{{ $note->created_at }}</td>
      <td>{{ $note->updated_at }}</td>
      <td>
        <div class="d-flex gap-2">
          <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning btn-sm">Modifica</a>

          <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa nota?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
          </form>
        </div>
      </td>
    </tr>
  </tbody>
</table>

<!-- Pulsante per tornare all'elenco -->
<div class="d-flex justify-content-between mt-3">
  <a href="{{ route('notes.index') }}" class="btn btn-primary">Visualizza tutte le note</a>
</div>

</div>
@endsection
