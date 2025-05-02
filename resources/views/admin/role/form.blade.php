<div class="card-body">
    <div class="form-group">
        <label for="name">Наименование</label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror" id="name"
               placeholder="Наименование"
               required maxlength="50" value="{{ old('name') ?? $role->name ?? '' }}">
    </div>
    <div class="form-group">
        <label for="slug">Идентификатор</label>
        <input type="text" name="slug"
               class="form-control @error('slug') is-invalid @enderror" id="slug"
               placeholder="Идентификатор"
               required maxlength="50" value="{{ old('slug') ?? $role->slug ?? '' }}">
    </div>
    <h5>Права</h5>
    <div class="form-group d-flex flex-wrap">
        @php
            // если это форма создания новой роли
            $perms = [];
            // если это форма редактирования роли
            if (isset($role))  $perms = $role->permissions->keyBy('id')->keys()->toArray();
            // форма была отправлена, но с ошибками
            if (old('perms')) $perms = old('perms');
        @endphp
        @foreach ($allperms as $item)
            @php $checked = in_array($item->id, $perms) @endphp
            <div class="form-check-inline w-25 mr-0">
                <input class="form-check-input" type="checkbox"
                       name="perms[]" id="perm-id-{{ $item->id }}"
                       value="{{ $item->id }}" @if($checked) checked @endif>
                <label class="form-check-label" for="perm-id-{{ $item->id }}">
                    {{ $item->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>
