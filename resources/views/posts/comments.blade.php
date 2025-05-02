<div class="comment-area">
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
                                    <h4 class="title">{{ $comment->user->name }}
                                        <span class="date">- {{ $comment->created_at }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="review-bottom">
                            <p>{{ $comment->content }}</p>
                            <div class="review-left">
                                <a href="#">Reply</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $comments->links() }}
        @else
            <p>К этому посту еще нет комментариев</p>
        @endif
    </div>
</div>
