@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Роли</h1>
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
                            <h3 class="card-title">Роли</h3>
                        </div>
                        <div class="card-body">
                            @perm('create-role')
                                <a href="{{ route('role.create') }}" class="btn btn-primary mb-3">Добавить роль</a>
                            @endperm
                            @if (count($roles))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Идентификатор</th>
                                            <th>Наименование</th>
                                            <th><i class="fas fa-pencil-alt"></i></th>
                                            <th><i class="fas fa-trash-alt"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $role->slug }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @perm('edit-role')
                                                        <a class="btn btn-primary btn-sm" href="{{ route('role.edit', ['role' => $role->id]) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endperm
                                                </td>
                                                <td>
                                                    @perm('delete-role')
                                                        <form action="{{ route('role.destroy', ['role' => $role->id]) }}" method="post" class="float-left">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Подтвердите удаление')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endperm
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>Ролей пока нет...</p>
                            @endif
                        </div>
                        <div class="card-footer clearfix">
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
