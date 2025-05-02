@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Альбомы</h1>
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
                            <h3 class="card-title">Новый альбом</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-create" role="form" method="post" action="{{ route('user.album.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="genre_id">Жанр</label>
                                    <select class="form-control @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id">
                                        @foreach($genres as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @isset($labels)
                                    <div class="form-group">
                                        <label for="label_id">Лейбл</label>
                                        <select class="form-control @error('label_id') is-invalid @enderror" id="label_id" name="label_id">
                                            @foreach($labels as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endisset

                                @isset($artists)
                                    <div class="form-group">
                                        <label for="artists">Артисты</label>
                                        <select name="artists[]" id="artists" class="select2" multiple="multiple" data-placeholder="Выбор артистов" style="width: 100%;">
                                            @foreach($artists as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endisset

                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror" id="name"
                                           placeholder="Название">
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="7" placeholder="Описание..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="cover">Обложка</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="cover" type="file" class="custom-file-input" name="cover">
                                            <label class="custom-file-label" for="cover">Выберите файл</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Теги</label>
                                    <select name="tags[]" id="tags" class="select2" multiple="multiple" data-placeholder="Выбор тегов" style="width: 100%;">
                                        @foreach($tags as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tracklist">Треклист</label>
                                    <input type="text" name="tracklist"
                                           class="form-control @error('tracklist') is-invalid @enderror" id="tracklist"
                                           placeholder="Html из Яндекс-музыки">
                                </div>

                                <div class="form-group">
                                    <label>Диски</label>
                                    <label>CD <a class="add-btn" data-main-format="discs" data-format="cd"><i class="fa fa-plus"></i></a></label>
                                    <label>DVD <a class="add-btn" data-main-format="discs" data-format="dvd"><i class="fa fa-plus"></i></a></label>
                                </div>

                                <div class="form-group">
                                    <label>Винил</label>
                                    <label>Черный <a class="add-btn" data-main-format="vinyl" data-format="black-vinyl"><i class="fa fa-plus"></i></a></label>
                                    <label>Цветной <a class="add-btn" data-main-format="vinyl" data-format="color-vinyl"><i class="fa fa-plus"></i></a></label>
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
