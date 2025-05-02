@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование пользователя</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror" id="name"
                                           value="{{ old('name') ?? $user->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror" id="email"
                                           value="{{ old('email') ?? $user->email }}" required>
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="change_password"
                                           id="change_password">
                                    <label class="form-check-label" for="change_password">
                                        Изменить пароль пользователя
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="password">Новый пароль</label>
                                    <input type="password" name="password"
                                           class="form-control" id="password">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Повторите пароль</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" id="password_confirmation">
                                </div>

                                <div class="form-group">
                                    @perm('assign-role')
                                        @include('admin.users.roles')
                                    @endperm
                                    @perm('assign-permission')
                                        @include('admin.users.perms')
                                    @endperm
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
