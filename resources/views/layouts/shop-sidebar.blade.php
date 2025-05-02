<div class="blog-sidebar mr-20px">
    <div class="search-widget">
        <form action="{{ route('shop.search') }}" method="get">
            <input name="s" class="@error('s') is-invalid @enderror" placeholder="Поиск" type="text" required />
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="sidebar-widget-group">
        <div class="sidebar-widget">
            <h3 class="sidebar-title">Жанры</h3>
            <div class="category-post">
                <ul>
                    @foreach($gnrs as $gnr)
                        <li>
                            <a href="{{ route('shop.genre', ['slug' => $gnr->slug]) }}" class="selected m-0">
                                {{ $gnr->name }}<span>({{ $gnr->albums_count }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="sidebar-widget">
            <h3 class="sidebar-title">Популярные альбомы</h3>
            <div class="recent-post-widget">
                @foreach($popular_albums as $album)
                    <div class="recent-single-post d-flex">
                        <div class="thumb-side">
                            <a href="{{ route('shop.album', ['slug' => $album->slug]) }}">
                                <img src="{{ $album->getImage() }}" alt="" />
                            </a>
                        </div>
                        <div class="media-side">
                            <span class="date">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>{{ $album->getPostDate() }}
                            </span>
                            <span class="date">
                                <i class="fa fa-eye" aria-hidden="true"></i>{{ $album->views }}
                            </span>
                            <h5>
                                <a href="{{ route('shop.album', ['slug' => $album->slug]) }}">{{ $album->name }}</a>
                            </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="sidebar-widget">
            <h3 class="sidebar-title">Популярные теги</h3>
            <div class="sidebar-widget-tag d-inline-block">
                <ul>
                    @foreach($tags as $tag)
                        <li>
                            <a href="{{ route('shop.tag', ['slug' => $tag->slug]) }}">{{ $tag->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
