<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Note;

class NoteController extends Controller
{

    // FUNZIONE --> PRESENTAZIONE DELLE NOTE
    public function index(): View
    {

        $notes = Note::all();
        $notes = Note::With('user')->paginate(10);

        return view('notes.index', ['notes' => $notes]);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // FUNZIONE --> CREAZIONE DELLE NOTE 
    public function create()
    {
        $note = new Note();
        return view('notes.create', ['note' => $note]);
    }

    // FUNZIONE --> STORAGGIO DELLE NOTE
    public function store(Request $request)
{
    $max_size = (int) ini_get('upload_max_filesize') * 1000;

    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required',
        'image' => [
            'required',
            'file',
            'image',
            'max:'.$max_size,
        ]
    ]);

    $file = $request->file('image');

    if (!$file->isValid()) {
        return back()->with('error', 'File non valido');
    }

    $filePath = $file->store('uploads', 'public');

    $note = new Note();
    $note->title = $request->input('title');
    $note->body = $request->input('body');
    $note->image_url = $filePath; // <-- CORRETTO
    $note->user_id = auth()->user()->id;
    $note->save();

    return redirect()->route('notes.index')->with('success', 'Nota creata con successo!');
}




    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> MODIFICA DELLE NOTE
    public function edit(string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        return view('notes.edit', ['note' => $note]); // Passa la nota alla vista
    }

    // FUNZIONE --> AGGIORNAMENTO DELLE NOTE
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        $note->title = $request->input('title');
        $note->body = $request->input('body');
        $note->save(); // Salva le modifiche

        return redirect()->route('notes.index')->with('success', 'Nota aggiornata con successo!');
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> CANCELLARE LE NOTE
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        $note->delete(); // Elimina la nota

        return redirect()->route('notes.index')->with('success', 'Nota eliminata con successo!');
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> MOSTRARE LE NOTE
    public function show(string $id)
    {
        $note = Note::with(relations: 'user')->find(id: $id);

        if ($note == null) {
            return "Nota non trovata";
        }

        return view('notes.show', compact('note'));
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> AUTENTICAZIONE UTENTE (automatica)
    public function __construct()
    {
        $this->middleware('auth');
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> BARRA DI RICERCA
    public function search(Request $request)
    {
        // Sanificazione input
        $query = trim($request->input('query'));

        // Esegui la ricerca nel titolo o nel corpo della nota
        $notes = Note::where('title', 'LIKE', "%$query%")
            ->orWhere('body', 'LIKE', "%$query%")
            ->paginate(10);

        if (count($notes) > 0) {
            return view('notes.index', ['notes' => $notes]);
        } else {
            return redirect()->route('notes.index')->with('error', 'Nessun risultato trovato per la ricerca: ' . $query);
        }
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // FUNZIONE --> CESTINO DELLE NOTE
    public function trashed(): View
    {
        $notes = Note::onlyTrashed()->with('user')->paginate(10); // Recupera le note eliminate
        return view('notes.trash', ['notes' => $notes]); // Passa le note alla vista


    }

    // FUNZIONE --> RIPRISTINO DELLE NOTE
    public function restore($id)
    {
        $note = Note::onlyTrashed()->find($id);
        $note->restore();

        return redirect()->route('notes.index')->with('success', 'Nota ripristinata con successo.');
    }
}
