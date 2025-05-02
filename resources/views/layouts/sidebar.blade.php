<div class="blog-sidebar mr-20px">
    <div class="search-widget">
        <form action="{{ route('blog.search') }}" method="get">
            <input name="s" class="@error('s') is-invalid @enderror" placeholder="Поиск" type="text" required />
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="sidebar-widget-group">
        <div class="sidebar-widget">
            <h3 class="sidebar-title">Категории</h3>
            <div class="category-post">
                <ul>
                    @foreach($cats as $cat)
                        <li>
                            <a href="{{ route('categories.single', ['slug' => $cat->slug]) }}" class="selected m-0">
                                {{ $cat->title }}<span>({{ $cat->posts_count }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="sidebar-widget">
            <h3 class="sidebar-title">Популярные посты</h3>
            <div class="recent-post-widget">
                @foreach($popular_posts as $post)
                    <div class="recent-single-post d-flex">
                        <div class="thumb-side">
                            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}">
                                <img src="{{ $post->getImage() }}" alt="" />
                            </a>
                        </div>
                        <div class="media-side">
                            <span class="date">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>{{ $post->getPostDate() }}
                            </span>
                            <span class="date">
                                <i class="fa fa-eye" aria-hidden="true"></i>{{ $post->views }}
                            </span>
                            <h5>
                                <a href="{{ route('posts.single', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
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
                            <a href="{{ route('tags.single', ['slug' => $tag->slug]) }}">{{ $tag->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
