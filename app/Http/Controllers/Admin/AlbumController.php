<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Label;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Показывает список всех альбомов
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $albums = Album::with('profile')->paginate(5);

        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $artists = Artist::pluck('name', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();

        return view('admin.albums.create', compact('genres', 'labels', 'artists', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function ajax_store(Request $request)
    {
        $messages = [
//            'name.required' => 'Поле Название обязательно для заполнения.',
            'required_without_all' => 'Необходимо указать цену хотя бы на одну позицию.'
        ];

        $attributes = [
            'name' => 'Название',
            'format.discs.format.cd.price' => 'Цена на CD',
            'format.discs.format.dvd.price' => 'Цена на DVD',
            'format.vinyl.format.black-vinyl.price' => 'Цена на Черный винил',
            'format.vinyl.format.color-vinyl.price' => 'Цена на Цветной винил',
        ];

        $validator = Validator::make($request->all(), [
            'genre_id' => 'required|integer',
            'label_id' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
            'tracklist' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'format.discs.format.cd.price' => 'required_without_all:format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.discs.format.dvd.price' => 'required_without_all:format.discs.format.cd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.black-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.color-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price|numeric',
        ], $messages, $attributes);

        if ($validator->passes()) {
            $request->merge(['profile_id' => auth()->user()->profile_id]);
//            $request->merge(['artists' => ['1', '2']]);

//            $profile = Profile::find(auth()->user()->profile_id);

            $artists = $request->input('artists');
            $artists = array_shift($artists);
            $artists = explode(',', $artists);
            $request->merge(['artists' => $artists]);

            $tags = $request->input('tags');
            $tags = array_shift($tags);
            $tags = explode(',', $tags);
            $request->merge(['tags' => $tags]);

            if ($request->hasFile('cover')) {
                $path = Album::uploadImage($request);

                $request->merge([
                    'images' => [
                        'cover' => [
                            'min' => $path['min'],
                            'full' => $path['full']
                        ],
                        'other' => []
                    ]
                ]);
            }

            $data = $request->all();

//            Log::info('Data', $artists);

            $album = Album::create($data);
            $album->artists()->sync($request->artists);
            $album->tags()->sync($request->tags);

            return response()->json([
                'success' => 'Новый альбом добавлен!',
                'request' => $data,
            ]);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::find($id);
        $genres = Genre::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $artists = Artist::pluck('name', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();

        return view('admin.albums.edit', compact('genres', 'labels', 'artists', 'tags', 'album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function ajax_update(Request $request)
    {
        $messages = [
            'required_without_all' => 'Необходимо указать цену хотя бы на одну позицию.'
        ];

        $attributes = [
            'name' => 'Название',
            'format.discs.format.cd.price' => 'Цена на CD',
            'format.discs.format.dvd.price' => 'Цена на DVD',
            'format.vinyl.format.black-vinyl.price' => 'Цена на Черный винил',
            'format.vinyl.format.color-vinyl.price' => 'Цена на Цветной винил',
        ];

        $validator = Validator::make($request->all(), [
            'album_id' => 'required|integer',
            'genre_id' => 'required|integer',
            'label_id' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
            'tracklist' => 'required',
            'format.discs.format.cd.price' => 'required_without_all:format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.discs.format.dvd.price' => 'required_without_all:format.discs.format.cd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.black-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.color-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price|numeric',
        ], $messages, $attributes);

        if ($validator->passes()) {
            $request->merge(['profile_id' => auth()->user()->profile_id]);

            $artists = $request->input('artists');
            $artists = array_shift($artists);
            $artists = explode(',', $artists);
            $request->merge(['artists' => $artists]);

            $tags = $request->input('tags');
            $tags = array_shift($tags);
            $tags = explode(',', $tags);
            $request->merge(['tags' => $tags]);

            $album = Album::find($request->album_id);

            if ($request->hasFile('cover')) {
                $path = Album::uploadImage($request, $album->images['cover']);

                $request->merge([
                    'images' => [
                        'cover' => [
                            'min' => $path['min'],
                            'full' => $path['full']
                        ],
                        'other' => []
                    ]
                ]);
            }

            $data = $request->all();

            $album->update($data);
            $album->artists()->sync($request->artists);
            $album->tags()->sync($request->tags);

            return response()->json([
                'success' => 'Изменения сохранены!',
                'img' => $path['min'],
            ]);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::find($id);
        $album->tags()->sync([]);
        Storage::deleteDirectory("albums/$album->slug");
        $album->delete();

        return redirect()->route('albums.index')->with('success', 'Альбом удален');
    }
}
