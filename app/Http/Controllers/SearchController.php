<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Game;
use MarcReichel\IGDBLaravel\Models\Game as IGDB_Game;
use MarcReichel\IGDBLaravel\Builder as IGDB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        $igdb = IGDB_Game::select('name, summary, cover')->with(['cover' => ['image_id']])->where('name', $request->search)->first();

        if (!$igdb) {
            return view('games.index')->withTitle($search)->withurl('/search/get/?search=' . $search  . '&');
        } else {
            https://images.igdb.com/igdb/image/upload/t_cover_big

            $game = Game::updateOrCreate(
                ['name' => $igdb->name],
                [
                    'igdb_id' => $igdb->id,
                    'description' => $igdb->summary,
                    'image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg',
                    'created_user_id' => 1,
                ]
            );

            return redirect()->route('game', $game);
        }
    }


    public function getSearch(Request $request)
    {
        $search = $request->search;
        $igdb = new IGDB('games/count');
        $count = $igdb->search($search)->first();
        $current_page = (int)$request->page;
        $per_page = 12;
        $offset = $current_page * $per_page;
        $last_page = ceil($count / $per_page);

        $igdb = IGDB_Game::select('name, cover')->with(['cover' => ['url']])->search($search)->limit($per_page)->offset($offset)->get();

        return json_encode([
            'current_page' => $current_page,
            'data' => $igdb,
            'last_page' => $last_page,
            'per_page' => $per_page,
            'total' => $count
        ]);

        $games = DB::table('games')
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->where('name', 'like', '%' . $search . '%')
            ->where('removed', '=', '0')
            ->paginate(12);

        $games->appends(['search' => $search])->links();

        return $games;
    }

    public function autocomplete($search)
    {
        $games = IGDB_Game::select('name, cover')->with(['cover' => ['url']])->search($search)->get();
        return $games; 
        return $igdb->search($search)->select('name')->limit('5')->get();
    }
}
