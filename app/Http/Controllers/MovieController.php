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

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $filterByGenre = $request->query('genre');
        $filterByName = $request->query('name');
        $moviesQuery = Movie::query();
        if ($filterByGenre !== null) {
            $moviesQuery->where('genre', $filterByGenre);
        }

        if ($filterByName !== null) {
            $moviesQuery
                ->where('movies.name', 'like', "%$filterByName%");
        }

        $movies = $moviesQuery
            ->with('genre')
            ->paginate(20)
            ->withQueryString();
        return view(
            'movies.index',
            compact('genres', 'movies', 'filterByGenre', 'filterByName')
        );
    }

    public function create(): View
    {
        $newMovie = new Movie();
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        return view('movies.create')
            ->with('genres', $genres)
            ->with('movie', $newMovie);
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newMovie = DB::transaction(function () use ($validatedData) {
            $newMovie = new Movie();
            $newMovie->title = $validatedData['title'];
            $newMovie->genre_code = $validatedData['genre_code'];
            $newMovie->year = $validatedData['year'];
            $newMovie->poster_filename = $validatedData['poster_filename'];
            $newMovie->synopsis = $validatedData['synopsis'];
            $newMovie->trailer_url = $validatedData['trailer_url'];
            $newMovie->save();
            return $newMovie;
        });
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->user->name}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function showCase(): View
    {
        return view('movies.showcase')->with('movies', Movie::get());;
    }
    public function showCurriculum(Movie $mov): View
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
        $movie = DB::transaction(function () use ($validatedData, $movie) {
            $movie->title = $validatedData['title'];
            $movie->genre_code = $validatedData['genre_code'];
            $movie->year = $validatedData['year'];
            $movie->poster_filename = $validatedData['poster_filename'];
            $movie->synopsis = $validatedData['synopsis'];
            $movie->trailer_url = $validatedData['trailer_url'];
            $movie->save();

            return $movie;
        });
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->user->name}</u></a> has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.show', ['movie' => $movie]);
            $totalMoviesScreenings = DB::scalar(
                'select count(*) from screenings where movie_id = ?',
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
        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Movie $movie): View
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        return view('movies.show')
            ->with('genres', $genres)
            ->with('movie', $movie);
    }

}
