<div class="comment-area" id="comment-area">
    <h2 class="comment-heading" data-aos="fade-up" data-aos-delay="200">Комментарии ({{ $comments->total() }})</h2>
    <div class="review-wrapper">
        @if ($comments->count())
            @foreach ($comments as $comment)
                <div class="single-review" id="comment-{{ $comment->id }}" data-aos="fade-up" data-aos-delay="200">
                    <div class="review-img">
                        <img src="/assets/front/images/blog-image/comment-img-1.webp" alt=""/>
                    </div>
                    <div class="review-content">
                        <div class="review-top-wrap">
                            <div class="review-left">
                                <div class="review-name">
                                    <h4 class="title">
                                        @if (!$comment->isVisible())
                                            <i class="fa fa-eye-slash text-danger" title="Предварительный просмотр"></i>
                                        @else
                                            <i class="fa fa-eye text-success" title="Комментарий опубликован"></i>
                                        @endif
                                        {{ $comment->user->name }}
                                        <span class="date">- {{ $comment->created_at }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="review-bottom">
                            <p>{{ $comment->content }}</p>
                            <div class="p-2 d-flex justify-content-end">
                                @if (!$comment->isVisible())
                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.comment.edit', ['comment' => $comment->id]) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('user.comment.destroy', ['comment' => $comment->id]) }}" method="post" class="float-left">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $comments->fragment('comment-area')->links() }}
        @else
            <p>К этому посту еще нет комментариев</p>
        @endif
    </div>
</div>
