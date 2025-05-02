@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование альбома</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $album->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-create" data-album-id="{{ $album->id }}" role="form" method="post" action="{{ route('user.album.store') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="genre_id">Жанр</label>
                                    <select class="form-control @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id">
                                        @foreach($genres as $k => $v)
                                            <option value="{{ $k }}" @if($k == $album->genre_id) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @isset($labels)
                                    <div class="form-group">
                                        <label for="label_id">Лейбл</label>
                                        <select class="form-control @error('label_id') is-invalid @enderror" id="label_id" name="label_id">
                                            @foreach($labels as $k => $v)
                                                <option value="{{ $k }}" @if($k == $album->label_id) selected @endif>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endisset

                                @isset($artists)
                                    <div class="form-group">
                                        <label for="artists">Артисты</label>
                                        <select name="artists[]" id="artists" class="select2" multiple="multiple" data-placeholder="Выбор артистов" style="width: 100%;">
                                            @foreach($artists as $k => $v)
                                                <option value="{{ $k }}" @if(in_array($k, $album->artists->pluck('id')->all())) selected @endif>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endisset

                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror" id="name"
                                           placeholder="Название"
                                           value="{{ $album->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="7" placeholder="Описание...">{{ $album->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="cover">Обложка</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="cover" type="file" class="custom-file-input" name="cover">
                                            <label class="custom-file-label" for="cover">Выберите файл</label>
                                        </div>
                                    </div>
                                    <div><img class="img-thumbnail mt-2" src="{{ $album->getImage() }}" alt="" width="200"></div>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Теги</label>
                                    <select name="tags[]" id="tags" class="select2" multiple="multiple" data-placeholder="Выбор тегов" style="width: 100%;">
                                        @foreach($tags as $k => $v)
                                            <option value="{{ $k }}" @if(in_array($k, $album->tags->pluck('id')->all())) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tracklist">Треклист</label>
                                    <input type="text" name="tracklist"
                                           class="form-control @error('tracklist') is-invalid @enderror" id="tracklist"
                                           placeholder="Html из Яндекс-музыки"
                                           value="{{ $album->tracklist }}">
                                </div>

                                <div class="form-group">
                                    <label>Диски</label>
                                    @isset($album->format['discs']['format']['cd']['name'])
                                        <label>CD <a class="remove-btn" data-main-format="discs" data-format="cd"><i class="fa fa-minus"></i></a></label>
                                        <label for="cd_price">Цена</label>
                                        <input class="form-control" id="cd_price" type="text" name="format[discs][format][cd][price]" value="{{ $album->format['discs']['format']['cd']['price'] }}">
                                        <label for="cd_description">Описание</label>
                                        <textarea class="form-control description" id="cd_description" name="format[discs][format][cd][description]" rows="7" placeholder="Описание...">{{ $album->format['discs']['format']['cd']['description'] }}</textarea>
                                    @else
                                        <label>CD <a class="add-btn" data-main-format="discs" data-format="cd"><i class="fa fa-plus"></i></a></label>
                                    @endisset
                                    @isset($album->format['discs']['format']['dvd']['name'])
                                        <label>DVD <a class="remove-btn" data-main-format="discs" data-format="dvd"><i class="fa fa-minus"></i></a></label>
                                        <label for="dvd_price">Цена</label>
                                        <input class="form-control" id="dvd_price" type="text" name="format[discs][format][dvd][price]" value="{{ $album->format['discs']['format']['dvd']['price'] }}">
                                        <label for="dvd_description">Описание</label>
                                        <textarea class="form-control description" id="dvd_description" name="format[discs][format][dvd][description]" rows="7" placeholder="Описание...">{{ $album->format['discs']['format']['dvd']['description'] }}</textarea>
                                    @else
                                        <label>DVD <a class="add-btn" data-main-format="discs" data-format="dvd"><i class="fa fa-plus"></i></a></label>
                                    @endisset
                                </div>

                                <div class="form-group">
                                    <label>Винил</label>
                                    @isset($album->format['vinyl']['format']['black-vinyl']['name'])
                                        <label>Черный <a class="remove-btn" data-main-format="vinyl" data-format="black-vinyl"><i class="fa fa-minus"></i></a></label>
                                        <label for="black-vinyl_price">Цена</label>
                                        <input class="form-control" id="black-vinyl_price" type="text" name="format[vinyl][format][black-vinyl][price]" value="{{ $album->format['vinyl']['format']['black-vinyl']['price'] }}">
                                        <label for="black-vinyl_description">Описание</label>
                                        <textarea class="form-control description" id="black-vinyl_description" name="format[vinyl][format][black-vinyl][description]" rows="7" placeholder="Описание...">{{ $album->format['vinyl']['format']['black-vinyl']['description'] }}</textarea>
                                    @else
                                        <label>Черный <a class="add-btn" data-main-format="vinyl" data-format="black-vinyl"><i class="fa fa-plus"></i></a></label>
                                    @endisset
                                    @isset($album->format['vinyl']['format']['color-vinyl']['name'])
                                        <label>Цветной <a class="remove-btn" data-main-format="vinyl" data-format="color-vinyl"><i class="fa fa-minus"></i></a></label>
                                        <label for="color-vinyl_price">Цена</label>
                                        <input class="form-control" id="color-vinyl_price" type="text" name="format[vinyl][format][color-vinyl][price]" value="{{ $album->format['vinyl']['format']['color-vinyl']['price'] }}">
                                        <label for="color-vinyl_description">Описание</label>
                                        <textarea class="form-control description" id="color-vinyl_description" name="format[vinyl][format][color-vinyl][description]" rows="7" placeholder="Описание...">{{ $album->format['vinyl']['format']['color-vinyl']['description'] }}</textarea>
                                    @else
                                        <label>Цветной <a class="add-btn" data-main-format="vinyl" data-format="color-vinyl"><i class="fa fa-plus"></i></a></label>
                                    @endisset
                                </div>

                                <button type="submit" class="btn btn-primary blog-btn">Сохранить</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
