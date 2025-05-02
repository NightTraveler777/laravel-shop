<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Label;
use App\Models\Tag;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;

class ShopController extends Controller
{
    public function index() {
//        $roots = Genre::where('parent_id', 0)->get();

        $albums = Album::with('genre', 'label')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('shop.index', compact('albums'));
    }

    public function genre($slug) {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        $albums = Album::where('genre_id', $genre->id)->paginate(12);
        return view('shop.genre', compact('genre', 'albums'));
    }

    public function label($slug) {
        $label = Label::where('slug', $slug)->firstOrFail();
        $albums = $label->albums()->orderBy('id', 'desc')->paginate(12);
//        $albums = Album::where('label_id', $label->id)->paginate(2);
        return view('shop.label', compact('label', 'albums'));
    }

    public function artist($slug) {
        $artist = Artist::where('slug', $slug)->firstOrFail();
        $albums = $artist->albums()->orderBy('id', 'desc')->paginate(12);
        return view('shop.artist', compact('artist', 'albums'));
    }

    public function tag($slug) {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $albums = $tag->albums()->orderBy('id', 'desc')->paginate(12);
        return view('shop.tag', compact('tag', 'albums'));
    }

    public function search(Request $request)
    {
        $request->validate([
            's' => 'required',
        ]);

        $s = $request->s;
        $albums = Album::like($s)->with('genre')->paginate(8);
        return view('shop.search', compact('albums', 's'));
    }

    public function album($slug) {
        $album = Album::where('slug', $slug)->firstOrFail();
        $album->views += 1;
        $album->update();
        $first = false;
        $formats = [];

        $tracks = $album->tracks()->with('artists')->orderBy('id', 'asc')->paginate(5);

//        $tracks = Track::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(5);

//        $track = GetId3::fromDiskAndPath('local', '/some/file.mp3');
        $track = GetId3::fromDiskAndPath('public', "albums/serenitatis/tracks/mp3/track4.mp3");
        $playtime = $track->getPlaytimeSeconds();

//        $contents = Storage::get(asset("/storage/albums/serenitatis/tracks/mp3/track1.mp3"));
//        $contents = Storage::get("/albums/serenitatis/tracks/mp3/track1.mp3");

        return view('shop.album', compact('album', 'first', 'formats', 'tracks'));
    }
}
