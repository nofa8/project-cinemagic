<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $filterByGenre = $request->Genre;
        $filterByName = $request->Title;
        $moviesQuery = Movie::query();


        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByName !== null) {
            $moviesQuery->where('movies.title', 'like', "%$filterByName%");
        }

        $movies = $moviesQuery
            ->with('genreRef')
            ->paginate(20)
            ->withQueryString();
        return view(
            'movies.index',
            compact( 'movies', 'filterByGenre', 'filterByName')
        );
    }

    public function indexDeleted(Request $request): View
    {
        $filterByGenre = $request->Genre;
        $filterByName = $request->Title;
        $moviesQuery = Movie::query()->onlyTrashed();


        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByName !== null) {
            $moviesQuery->where('movies.title', 'like', "%$filterByName%");
        }

        $movies = $moviesQuery
            ->with('genreRefD')
            ->paginate(20)
            ->withQueryString();

        return view(
            'movies.index',
            compact( 'movies', 'filterByGenre', 'filterByName')
        )->with('tr', "trash");
    }


    public function save(Movie $movie): RedirectResponse{
        if (!$movie->trashed()){
            return view('theaters.deleted');    
        }
        $extra = "";
        if ($movie->genreRefD->trashed()){
            $movie->genre_code = Genre::first()->code;
            $movie->save();
            $extra = "\n Movie genre changed to ".$movie->genre_code.", please correct it.";
        }
        $movie->restore();
        return redirect()->back()->with('alert-type', 'success')
        ->with('alert-msg', "Movie \"{$movie->title}\" has been restored.".$extra);;
    }
 
    public function destructionForced(Movie $movie): RedirectResponse{
        if (!$movie->trashed()){
            return redirect()->route('theaters.index')
                ->with('alert-type', 'error')
                ->with('alert-msg', "Theater \"{$movie->title}\" is not in the deleted list.");
        }

        if ($movie?->screenings->count() > 0) {
            $movie->screenings->each(function ($screening) {
                $screening?->tickets->each(function ($ticket) {
                    $ticket?->purchase->each(function ($purchase) {
                        $purchase->delete(); 
                    }); 
                    $ticket->delete(); 
                  }); 

                $screening->delete(); 
              });              
        }

        if ($movie->poster_filename && Storage::exists('public/posters/' . $movie->poster_filename)) {
            Storage::delete('public/posters/' . $movie->poster_filename);
        }
        $name = $movie->title;
        $movie->forceDelete();
        return redirect()->route('movies.deleted')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Movie \"{$name}\" has been permanently deleted. With its associated screenings, tickets and purchases");
    }


    public function destruction(Movie $movie): RedirectResponse{
        if (!$movie->trashed()){
            return redirect()->route('movies.deleted')
                ->with('alert-type', 'error')
                ->with('alert-msg', "Movie \"{$movie->title}\" is not in the deleted list.");
        }

        if ($movie?->screenings->count() > 0) {
            return redirect()->route('movies.deleted')
            ->with('alert-type', 'error')
            ->with('alert-msg', "Movie \"{$movie->title}\" has screenings associated with it, can't be removed normally.");        
        }

        if ($movie->poster_filename && Storage::exists('public/posters/' . $movie->poster_filename)) {
            Storage::delete('public/posters/' . $movie->poster_filename);
        }
        $name = $movie->title;
        $movie->forceDelete();
        return redirect()->route('movies.deleted')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Movie \"{$name}\" has been permanently deleted. With its associated screenings, tickets and purchases");
    }

    public function create(): View
    {
        $movie = new Movie();
        return view('movies.create')
            ->with('movie', $movie);
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newMovie = DB::transaction(function () use ($validatedData) {
            $newMovie = new Movie();
            $newMovie->title = $validatedData['title'];
            $newMovie->genre_code = $validatedData['genre_code'];
            $newMovie->year = $validatedData['year'];
            if ( !empty($validatedData['poster_filename'])) {
                $newMovie->poster_filename = $validatedData['poster_filename'];
            }
            $newMovie->synopsis = $validatedData['synopsis'];
            $newMovie->trailer_url = $validatedData['trailer_url'];
            $newMovie->save();
            return $newMovie;
        });
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function showCase(Request $request): View
    {

        $filterByGenre = $request->Genre;
        $filterByName = $request->Title;
        $moviesQuery = Movie::query();


        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByName !== null) {
            $moviesQuery->where('movies.title', 'like', "%$filterByName%");
        }

        #$moviesQuery->groupBy("movies.title");
        $now = Carbon::now();
        $forteendaysfromnow = Carbon::now()->addDays(14)->format("Y-m-d");
        $movies = $moviesQuery
            ->with('genreRef')
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->where(function ($query) {
                $query->where('date', '>', now()->startOfDay())
                    ->orWhere(function ($query) {
                        $query->where('date', '=', now()->startOfDay())
                            ->where('start_time', '>', now()->format('H:i:s'));
                    });
            })
            ->select('movies.*') // Ensure only movie columns are selected
            ->distinct() // Ensure unique movies in case of multiple screenings within 14 days
            ->paginate(20)
            ->withQueryString();

        return view(
            'movies.showcase',
            compact('movies', 'filterByGenre', 'filterByName')
        );



        #return view('movies.showcase')->with('movies', $allMovies);;
    }
    public function showScreenings(Movie $mov): View
    {
        return view('movies.curriculum')->with('movie', $mov);
    }

    public function edit(Movie $movie): View
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        return view('movies.edit')
            ->with('genres', $genres)
            ->with('movie', $movie);
    }

    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $validatedData = $request->validated();
        $movie = DB::transaction(function () use ($validatedData, $movie, $request) {
            $movie->title = $validatedData['title'];
            $movie->year = $validatedData['year'];
            $movie->genre_code = $validatedData['genre_code'];
            $movie->synopsis = $validatedData['synopsis'];
            $movie->trailer_url = $validatedData['trailer_url'];
            $movie->save();
            if ($request->hasFile('poster_filename')) {
                if (
                    $movie->poster_filename &&
                    Storage::fileExists('public/posters/' . $movie->poster_filename)
                ) {
                    Storage::delete('public/posters/' . $movie->poster_filename);
                }
                $path = $request->poster_filename->store('public/posters');
                $movie->poster_filename = basename($path);
                $movie->save();
            }
            return $movie;
        });
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> has been updated successfully!";
        return redirect()->route('movies.showcase')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.show', ['movie' => $movie]);
            $totalMoviesScreenings = DB::scalar(
                'select count(*) from screenings where NOW() < CONCAT(date, " ", start_time) AND movie_id = ?;',
                [$movie->id]
            );
            if ($totalMoviesScreenings == 0) {
                DB::transaction(function () use ($movie) {
                    $movie->delete();
                });
                $alertType = 'success';
                $alertMsg = "Movie {$movie->title} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMoviesScreenings <= 0 => "",
                    $totalMoviesScreenings == 1 => "1 screening with this movie",
                    $totalMoviesScreenings > 1 => "$totalMoviesScreenings screenings with this movie",
                };
                $alertMsg = "Movie <a href='$url'><u>{$movie->title}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            debug($error);
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the movie
                            <a href='$url'><u>{$movie->title}</u></a>
                            because there was an error with the operation!";
        }
        if ($alertType == "success"){
            return redirect()->route('movies.index')
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        }
        return redirect()->back()
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Movie $movie): View
    {
        return view('movies.show')
            ->with('movie', $movie);

    }
    public function destroyImage(Movie $movie): RedirectResponse
    {
        if ($movie->imageExists) {
            Storage::delete("public/posters/{$movie->poster_filename}");
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Poster of movie {$movie->title} has been deleted.");
    }

}
