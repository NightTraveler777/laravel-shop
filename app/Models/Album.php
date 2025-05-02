<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Album extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['profile_id', 'genre_id', 'label_id', 'name', 'description', 'tracklist', 'slug', 'images', 'format'];

    protected $casts = [
        'images' => 'array',
        'format' => 'array'
    ];

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function label() {
        return $this->belongsTo(Label::class);
    }

    public function artists() {
        return $this->belongsToMany(Artist::class)->withTimestamps();
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function tracks() {
        return $this->hasMany(Track::class);
    }

    public function profile() {
        return $this->belongsTo(Profile::class);
    }

    public function baskets() {
        return $this->belongsToMany(Basket::class)->withPivot('quantity');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public static function uploadImage(Request $request, $images = null) {
        if ($request->hasFile('cover')) {
            if ($images) {
                Storage::delete($images['min']);
                Storage::delete($images['full']);
            }

//            Log::info('Data', $images);

            $filenamewithextension = $request->file('cover')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('cover')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
            $minfilenametostore = $filename.'_'.time().'_min.'.$extension;

            $folder = SlugService::createSlug(Album::class, 'slug', $request->name);
            /*$path = $file->store("/albums/{$folder}/images");
            $path = Storage::disk('public')->path($path);*/

            //Upload File
            $request->file('cover')->storeAs("albums/{$folder}/images", $filenametostore);
            $request->file('cover')->storeAs("albums/{$folder}/images", $minfilenametostore);

            //Resize image here
            $thumbnailpath = public_path("storage/albums/{$folder}/images/".$minfilenametostore);
//            $thumbnailpath = '/';
            $img = Image::make($thumbnailpath)->fit(150, 150, function($constraint) {
                $constraint->aspectRatio();
            }, 'top');
            $img->save($thumbnailpath);

            return [
                'min' => "albums/{$folder}/images/{$minfilenametostore}",
                'full' => "albums/{$folder}/images/{$filenametostore}"
            ];
        }
        return null;
    }

    public function getImage() {
        if (!$this->images['cover']['min']) {
            return asset('no-img.png');
        }
        return asset("storage/{$this->images['cover']['min']}");
    }

    public function getPostDate() {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
    }

    public function scopeLike($query, $s) {
        return $query->where('name', 'LIKE', "%{$s}%")->orWhere('description', 'LIKE', "%{$s}%");
    }
}
