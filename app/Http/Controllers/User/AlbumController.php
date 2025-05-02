<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Label;
use App\Models\Profile;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;


class AlbumController extends Controller
{
    /**
     * Показывает список всех альбомов пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $profile = Profile::where('user_id', '=', auth()->user()->id)->get();

        $albums = Album::where('profile_id', '=', auth()->user()->profile_id)->with('profile')->paginate(5);

        /*$albums = Album::whereRelation('profile', 'user_id', '=', auth()->user()->id)
            ->whereRelation('profile', 'role_id', '=', auth()->user()->roles[0]->id)
            ->paginate(5);*/

//        $albums = Album::whereUserId(auth()->user()->id)->with('genre')->paginate(5);
        return view('user.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::pluck('name', 'id')->all();
        $profile = Profile::find(auth()->user()->profile_id);

//        $tags = Tag::pluck('title', 'id')->all();

        if ($profile->type === 'Артист') {
            $labels = Label::pluck('name', 'id')->all();
            return view('user.albums.create', compact('genres', 'labels'));
        }

        if ($profile->type === 'Лейбл') {
            $artists = Artist::pluck('name', 'id')->all();
            return view('user.albums.create', compact('genres', 'artists'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'genre_id' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
        ]);

        $request->merge(['profile_id' => auth()->user()->profile_id]);
        $request->merge([
            'images' => [
                "cover" => [
                    "min" => "serenitatis/images/biCT1zQOpX4bteTmUiW2xxKsrYGMqij6d8IDTXrN.jpg",
                    "full" => "serenitatis/images/biCT1zQOpX4bteTmUiW2xxKsrYGMqij6d8IDTXrN.jpg"
                ],
                "other" => []
            ]
        ]);
        /*$request->merge([
            'format' => [
                'digital' => [
                    'name' => 'Digital',
                    'format' => [
                        'mp3' => [
                            'name' => 'Mp3',
                            'price' => '800',
                            'description' => ''
                        ]
                    ]
                ]
            ]
        ]);*/

        $formats = [
            'format.digital.format.mp3.price',
            'format.digital.format.wav.price',
            'format.digital.format.wav24.price'
        ];

//        dd($request['format']);

        if ($request->hasAny($formats)) {
            $data = $request->all();
            Arr::set($data, 'format.digital.name', 'Digital');
            Arr::set($data, 'format.digital.format.mp3.name', 'Mp3');
            Arr::set($data, 'format.digital.format.mp3.description', 'Mp3');
        }

//        $data = $request->all();
//        $data['thumbnail'] = Album::uploadImage($request);

        $post = Album::create($data);
//        $post->tags()->sync($request->tags);

//        $this->notify($post);

//        return redirect()->route('user.post.show', ['post' => $post->id])->with('success', 'Статья добавлена');

        return redirect()->route('user.album.index')->with('success', 'Альбом добавлен');
    }

    public function ajax(Request $request) {
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
            'label_id' => 'sometimes|required|integer',
            'artist_id' => 'sometimes|required|integer',
            'name' => 'required',
            'description' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'format.discs.format.cd.price' => 'required_without_all:format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.discs.format.dvd.price' => 'required_without_all:format.discs.format.cd.price,format.vinyl.format.black-vinyl.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.black-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.color-vinyl.price|numeric',
            'format.vinyl.format.color-vinyl.price' => 'required_without_all:format.discs.format.cd.price,format.discs.format.dvd.price,format.vinyl.format.black-vinyl.price|numeric',
        ], $messages, $attributes);

        if ($validator->passes()) {
            $request->merge(['profile_id' => auth()->user()->profile_id]);

            $profile = Profile::find(auth()->user()->profile_id);

            if ($profile->type === 'Лейбл') {
                $label = Label::find(auth()->user()->profile_id);
                $request->merge(['label_id' => $label->id]);
            }

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

            $album = Album::create($data);

            if ($profile->type === 'Лейбл') {
                $album->artists()->sync([$request->artist_id]);
            }

            if ($profile->type === 'Артист') {
                $artist = Artist::find(auth()->user()->profile_id);
                $album->artists()->sync([$artist->id]);
            }

            return response()->json(['success' => 'Новый альбом добавлен!']);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        //
    }
}
