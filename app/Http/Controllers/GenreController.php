<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreFormRequest;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    public function index(): View
    {
        return view('genres.index')
            ->with('genres', Genre::orderBy('name')->paginate(20));
    }


    public function indexDeleted(): View
    {
        return view('genres.index')
            ->with('genres', Genre::orderBy('name')->onlyTrashed()->paginate(20))->with('tr', "trash");
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')
            ->with('genre', $newGenre);
    }


    public function save(Genre $genre): RedirectResponse{
        if (!$genre->trashed()){
            return view('genres.deleted');    
        }
        $genre->restore();
        return redirect()->back()->with('alert-type', 'success')
        ->with('alert-msg', "Genre \"{$genre->name}\" has been restored.");;
    }
 
    public function destruction (genre $genre): RedirectResponse{
        if (!$genre->trashed()){
            return redirect()->route('genres.deleted')
                ->with('alert-type', 'error')
                ->with('alert-msg', "genre \"{$genre->name}\" is not in the deleted list.");
        }
        $many = 0;
        if ($genre?->movies()->withTrashed()->count() > 0) {
            $genre->movies()->withTrashed()->each(function ($many) {
                $many++;
              });              
        }

        if ($many != 0) {
            return redirect()->route('genres.deleted')
                ->with('alert-type', 'error')
                ->with('alert-msg', "genre \"{$genre->name}\" has ".$many." movies.");
        }
        $name = $genre->name;
        $genre->forceDelete();
        return redirect()->route('genres.deleted')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Genre \"{$name}\" has been permanently deleted.");
    }


    public function store(GenreFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newGenre = DB::transaction(function () use ($validatedData) {
            $newGenre = new Genre();
            $newGenre->code = $validatedData['code'];
            $newGenre->name = $validatedData['name'];
            $newGenre->save();
            return $newGenre;
        });


        $url = route('genres.show', ['genre' => $newGenre]);
        $htmlMessage = "Genre <a href='$url'><u>{$newGenre->name}</u></a> ({$newGenre->code}) has been created successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Genre $genre): View
    {
        return view('genres.edit')
            ->with('genre', $genre);
    }

    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());
        $url = route('genres.show', ['genre' => $genre]);
        $htmlMessage = "Genre <a href='$url'><u>{$genre->name}</u></a> ({$genre->code}) has been updated successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {
            $url = route('genres.show', ['genre' => $genre]);
            $totalMovies = DB::scalar(
                'select count(*) from movies where genre_code = ?',
                [$genre->code]
            );
            if ($totalMovies == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Genre {$genre->name} ({$genre->code}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMovies <= 0 => "",
                    $totalMovies == 1 => "there is 1 movie in the genre",
                    $totalMovies > 1 => "there are $totalMovies movies in the genre",
                };
                $alertMsg = "Genre <a href='$url'><u>{$genre->name}</u></a> ({$genre->code}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the genre
                            <a href='$url'><u>{$genre->name}</u></a> ({$genre->code})
                            because there was an error with the operation!";
        }
        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Genre $genre): View
    {
        return view('genres.show')->with('genre', $genre);
    }
}
