<div id="comment-form" class="blog-comment-form">
    <h2 class="comment-heading" data-aos="fade-up" data-aos-delay="200">Оставить комментарий</h2>

    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <form method="post" action="{{ route('blog.comment', ['post' => $post->id]) }}">
        <div class="row">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="col-md-12" data-aos="fade-up" data-aos-delay="200">
                <div class="single-form m-0">
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" placeholder="Текст комментария"
                              maxlength="500" rows="4">{{ old('content') ?? '' }}</textarea>
                </div>
            </div>
            <div class="col-md-12" data-aos="fade-up" data-aos-delay="200">
                <button class="submit-btn mt-30px" type="submit">Отправить</button>
            </div>
        </div>
    </form>
</div>
