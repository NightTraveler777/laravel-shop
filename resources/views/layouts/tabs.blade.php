<div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
    <ul role="tablist" class="nav flex-column dashboard-list">
        <li><a href="{{ route('user.index') }}" class="nav-link active">Панель управления</a></li>
        <li><a href="{{ route('user.profile') }}" class="nav-link">Управление профилями</a></li>
        @perm('create-post')
            <li><a href="{{ route('user.post.create') }}" class="nav-link">Новая публикация</a></li>
        @endperm
        <li><a href="{{ route('user.post.index') }}" class="nav-link">Ваши публикации</a></li>
        <li><a href="{{ route('user.comment.index') }}" class="nav-link">Ваши комментарии</a></li>
        <li><a href="{{ route('user.album.index') }}" class="nav-link">Ваши альбомы</a></li>
        <li><a href="{{ route('user.album.create') }}" class="nav-link">Новый альбом</a></li>
        <li><a href="#orders" data-bs-toggle="tab" class="nav-link">Заказы</a></li>
        <li><a href="#downloads" data-bs-toggle="tab" class="nav-link">Загрузки</a></li>
        <li><a href="#address" data-bs-toggle="tab" class="nav-link">Адреса</a></li>
        <li><a href="#account-details" data-bs-toggle="tab" class="nav-link">Детали профиля</a>
        </li>
        <li><a href="login.html" class="nav-link">Выход</a></li>
    </ul>
</div>
