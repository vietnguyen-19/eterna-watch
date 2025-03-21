@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-4 pb-lg-3"></div>
        <section class="shop-main container d-flex">
            <div style="border: 1px solid rgb(202, 202, 202); border-radius: 3px" class="shop-sidebar side-sticky bg-body p-4"
                id="shopFilter">
                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Danh mục
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-11" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <a href="{{ route('client.blog', ['category' => $category->name]) }}"
                                                class="menu-link py-1">
                                                {{ $category->name }} <span
                                                    class="text-muted">({{ $category->posts_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->
                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                                aria-controls="accordion-filter-2">
                                Thương hiệu
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-11" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <a href="#" class="menu-link py-1">{{ $brand->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->



                <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                                aria-controls="accordion-filter-size">
                                Tags
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('client.blog', ['tag' => $tag->name]) }}"
                                            class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">
                                            {{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion -->
            </div><!-- /.shop-sidebar -->

            <div class="shop-list flex-grow-1">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <article class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h1 class="card-title text-center mb-3">{{ $post->title }}</h1>
                                    <div
                                        class="d-flex justify-content-center flex-wrap text-muted small mb-4 align-items-center">
                                        <span class="me-3">By <strong>{{ $post->user->name }}</strong></span>
                                        <span
                                            class="me-3">{{ \Carbon\Carbon::parse($post->pushlisted_at)->format('M d, Y') }}</span>
                                        @foreach ($post->categories as $item)
                                            <span style="border-radius: 5px"
                                                class="btn btn-sm bg-primary text-white me-1">{{ $item->name }}</span>
                                        @endforeach
                                    </div>
                                    <img loading="lazy" class="h-auto"
                                        src="{{ Storage::url($post->image ?? 'avatar/default.jpeg') }}" width="100%"
                                        height="auto" alt="">
                                    <div class="content-editor text-dark">
                                        {!! $post->content !!}
                                    </div>
                                </div>
                            </article>

                            <nav class="mt-4 d-flex justify-content-between">
                                <a href="#" class="btn btn-outline-secondary d-flex align-items-center">
                                    <svg class="me-2" width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                    <span>Bài viết trước</span>
                                </a>
                                <a href="#" class="btn btn-outline-secondary d-flex align-items-center">
                                    <span class="me-2">Bài viết tiếp theo</span>
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="blog-single__reviews p-3 mt-5">
                    <h2 class="blog-single__reviews-title text-center fw-bold mb-4">BÌNH LUẬN</h2>

                    <div class="blog-single__reviews-list">
                        @if (session('error'))
                            <div class="alert alert-error"
                                style="display: flex; align-items: center; padding: 8px 12px; margin-bottom: 12px; background: #ffe6e6; color: #d32f2f; border-radius: 4px; font-size: 14px;">
                                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success"
                                style="display: flex; align-items: center; padding: 8px 12px; margin-bottom: 12px; background: #e6ffe6; color: #2e7d32; border-radius: 4px; font-size: 14px;">
                                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="blog-single__reviews-item d-flex align-items-start p-3 border rounded shadow-sm mb-3">
                            @if ($comments->isEmpty())
                                <p class="text-muted"><i>Chưa có đánh giá về sản phẩm.</i></p>
                            @else
                                <div class="" style="width:100%; margin: 0 auto;">
                                    @foreach ($comments as $comment)
                                        <div class="" style="border-bottom: 1px solid #eee; padding: 20px 0;">
                                            <div class="review-container" style="display: flex; gap: 15px;">
                                                <!-- Avatar -->
                                                <div class="">
                                                    <img loading="lazy"
                                                        src="{{ Storage::url($comment->user->avatar ?? 'avatar/default.jpeg') }}"
                                                        alt="{{ $comment->user->name }}"
                                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                                                </div>

                                                <!-- Nội dung review -->
                                                <div style="width:100%" class="" style="flex: 1;">
                                                    <div class="review-header"
                                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                                        <h6 style="margin: 0; font-size: 16px; font-weight: 600;">
                                                            {{ $comment->user->name }}
                                                            <span
                                                                style="font-size: 12px; color: #888; font-weight: normal;">
                                                                | {{ $comment->created_at->format('F d, Y') }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <!-- Đánh giá sao -->
                                                    <div class="reviews-group"
                                                        style="display: flex; gap: 4px; margin-bottom: 10px;">
                                                        @for ($i = 0; $i < $comment->rating; $i++)
                                                            <svg class="review-star" viewBox="0 0 9 9"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                style="width: 14px; height: 14px; fill: #ffc107;">
                                                                <use href="#icon_star" />
                                                            </svg>
                                                        @endfor
                                                    </div>

                                                    <!-- Nội dung bình luận -->
                                                    <div
                                                        style="width: 100%; font-size: 14px; color: #333; line-height: 1.5;">
                                                        <p style="margin: 0;">{{ $comment->content }}</p>
                                                    </div>


                                                    <!-- Nút trả lời -->
                                                    <div class="review-actions"
                                                        style="display: flex; gap: 15px; margin-top: 8px;">
                                                        <!-- Nút Trả lời -->
                                                        <div class="review-action">
                                                            <a href="#" class="reply-btn"
                                                                data-comment-id="{{ $comment->id }}"
                                                                data-entity-id="{{ $comment->entity_id }}"
                                                                style="color: #3c6ae7; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                <i>Trả lời</i>
                                                            </a>
                                                        </div>

                                                        <!-- Nút Xóa và Sửa (chỉ hiển thị nếu bình luận thuộc về người dùng hiện tại) -->
                                                        @if (Auth::check() && Auth::id() === $comment->user_id)
                                                            <!-- Nút Xóa -->
                                                            <div class="review-action">
                                                                <form
                                                                    action="{{ route('comments.delete', ['comment' => $comment->id, 'entity_id' => $comment->entity_id]) }}"
                                                                    method="POST" class="delete-form"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a href="#" class="delete-btn"
                                                                        data-comment-id="{{ $comment->id }}"
                                                                        style="color: #e74c3c; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                        <i>Xóa</i>
                                                                    </a>
                                                                </form>
                                                            </div>

                                                            <!-- Nút Sửa -->
                                                            <div class="review-action">
                                                                <a href="#" class="update-btn"
                                                                    data-comment-id="{{ $comment->id }}"
                                                                    style="color: #1e1e1e; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                    <i>Sửa</i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Form Trả lời (ẩn mặc định) -->
                                                    <div class="reply-form" id="reply-form-{{ $comment->id }}"
                                                        style="display: none; margin-top: 15px; width:100%">
                                                        <form
                                                            action="{{ route('comments.reply', ['comment' => $comment->id, 'entity_id' => $comment->entity_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <textarea name="content" rows="2" placeholder="Viết câu trả lời..."
                                                                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; box-sizing: border-box;">{{ old('content') }}</textarea>
                                                            @if ($errors->has('content'))
                                                                <span
                                                                    style="color: #e74c3c; font-size: 12px; display: block; margin-top: 5px;">
                                                                    {{ $errors->first('content') }}
                                                                </span>
                                                            @endif
                                                            <input type="hidden" name="entity_id"
                                                                value="{{ $comment->entity_id }}">
                                                            <div style="display: flex; gap: 10px; margin-top: 8px;">
                                                                <button type="submit"
                                                                    style="background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                                                                    Gửi
                                                                </button>
                                                                <button type="button" class="cancel-reply"
                                                                    style="background: none; color: #888; border: none; cursor: pointer;">
                                                                    Hủy
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Form Sửa (ẩn mặc định) -->
                                                    @if (Auth::check() && Auth::id() === $comment->user_id)
                                                        <div class="update-form" id="update-form-{{ $comment->id }}"
                                                            style="display: none; margin-top: 15px; padding-left: 30px; width:100%">
                                                            <form
                                                                action="{{ route('comments.update', ['comment' => $comment->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <textarea name="content" rows="2" placeholder="Chỉnh sửa bình luận..."
                                                                    style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; box-sizing: border-box;">{{ $comment->content }}</textarea>

                                                                @error('content')
                                                                    <span
                                                                        style="color: #e74c3c; font-size: 12px; display: block; margin-top: 5px;">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror

                                                                <div style="display: flex; gap: 10px; margin-top: 8px;">
                                                                    <button type="submit"
                                                                        style="background: #1e1e1e; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                                                                        Lưu
                                                                    </button>
                                                                    <button type="button" class="cancel-update"
                                                                        style="background: none; color: #888; border: none; cursor: pointer;">
                                                                        Hủy
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    @if ($comment->replies->count() > 0)
                                                        <div class="replies"
                                                            style="margin-top: 15px; padding-left: 30px; border-left: 2px solid #f0f0f0;">
                                                            @foreach ($comment->replies as $reply)
                                                                @include('client.partials.comment', [
                                                                    'comment' => $reply,
                                                                ])
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="blog-single__review-form mt-4 p-4 border rounded shadow-sm">
                        <form class="" method="POST" action="{{ route('comments.store_post', $post->id) }}">
                            @csrf
                            <h5 class="fw-bold mb-3">Hãy là người đầu tiên nhận xét về “Áo thun Cotton có thông điệp”</h5>
                            <p class="text-muted small">Địa chỉ email của bạn sẽ không được công khai. Các trường bắt buộc
                                được đánh dấu *</p>

                            <div class="mb-3">
                                <textarea id="form-input-review" name="content" class="form-control" placeholder="Nhập bình luận của bạn"
                                    cols="30" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">Gửi bình luận</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </section><!-- /.shop-main container -->
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
    <script>
        // Đặt trong file JS riêng hoặc trong thẻ <script> ở cuối blade
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>

                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);

                // Hiển thị form trả lời
                replyForm.style.display = 'block';

                // Focus vào textarea
                replyForm.querySelector('textarea').focus();
            });
        });

        document.querySelectorAll('.cancel-reply').forEach(button => {
            button.addEventListener('click', function() {
                const replyForm = this.closest('.reply-form');
                replyForm.style.display = 'none'; // Ẩn form khi bấm Hủy
            });
        });
    </script>
    <!-- JavaScript để tự động ẩn thông báo -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chọn tất cả các thông báo
            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(alert => {
                // Ẩn thông báo sau 3 giây (3000ms)
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease'; // Hiệu ứng mờ dần
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Xóa hẳn sau khi mờ
                }, 5000); // Thời gian chờ trước khi bắt đầu ẩn
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý nút Xóa
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Ngăn hành vi mặc định của link

                    const form = this.closest('.delete-form');
                    const reviewItem = this.closest(
                        '.product-single__reviews-item'); // Lấy phần tử cha chứa bình luận

                    // Xác nhận trước khi xóa
                    if (confirm('Bạn có chắc muốn xóa bình luận này không?')) {
                        // Gửi yêu cầu xóa bằng AJAX
                        fetch(form.action, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    reviewItem
                                        .remove(); // Xóa phần tử product-single__reviews-item khỏi DOM
                                } else {
                                    alert(data.error || 'Có lỗi xảy ra khi xóa bình luận!');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Có lỗi xảy ra khi xóa bình luận!');
                            });
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".update-btn").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    let commentId = this.getAttribute("data-comment-id");
                    let form = document.getElementById(`update-form-${commentId}`);

                    // Ẩn tất cả các form trước khi hiển thị form được chọn
                    document.querySelectorAll(".update-form").forEach(f => {
                        if (f !== form) f.style.display = "none";
                    });

                    // Hiển thị hoặc ẩn form chỉnh sửa
                    form.style.display = (form.style.display === "none" || form.style.display ===
                        "") ? "block" : "none";
                });
            });
            document.querySelectorAll(".cancel-update").forEach(button => {
                button.addEventListener("click", function() {
                    let form = this.closest(".update-form");
                    form.style.display = "none";
                });
            });
        });
    </script>
@endsection
@section('style')
@endsection
