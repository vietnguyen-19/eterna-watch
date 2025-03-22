<!-- resources/views/partials/comment.blade.php -->
<div style="border-bottom: 1px solid #eee; padding: 20px 0; width: 100%">
    <div class="review-container" style="display: flex; gap: 15px;">
        <!-- Avatar -->
        <div class="">
            <img loading="lazy" src="{{ Storage::url($comment->user->avatar ?? 'avatar/default.jpeg') }}"
                alt="{{ $comment->user->name }}"
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
        </div>

        <!-- Nội dung review -->
        <div class="customer-review" style="flex: 1;">
            <div class="review-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <h6 style="margin: 0; font-size: 16px; font-weight: 600;">
                    {{ $comment->user->name }}
                    <span style="font-size: 12px; color: #888; font-weight: normal;">
                        | {{ $comment->created_at->format('F d, Y') }}
                    </span>
                </h6>
            </div>

            <!-- Đánh giá sao -->
            <div class="reviews-group" style="display: flex; gap: 4px; margin-bottom: 10px;">
                @for ($i = 0; $i < $comment->rating; $i++)
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                        style="width: 14px; height: 14px; fill: #ffc107;">
                        <use href="#icon_star" />
                    </svg>
                @endfor
            </div>

            <!-- Nội dung bình luận -->
            <div style="width: 100%; font-size: 14px; color: #333; line-height: 1.5;">
                <p style="margin: 0;">{{ $comment->content }}</p>
            </div>


            <!-- Nút trả lời -->
            <div class="review-actions" style="display: flex; gap: 15px; margin-top: 8px;">
                <!-- Nút Trả lời -->
                <div class="review-action">
                    <a href="#" class="reply-btn" data-comment-id="{{ $comment->id }}"
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
                            method="POST" class="delete-form" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="delete-btn" data-comment-id="{{ $comment->id }}"
                                style="color: #e74c3c; font-size: 13px; text-decoration: none; font-style: italic;">
                                <i>Xóa</i>
                            </a>
                        </form>
                    </div>

                    <!-- Nút Sửa -->
                    <div class="review-action">
                        <a href="#" class="update-btn" data-comment-id="{{ $comment->id }}"
                            data-entity-id="{{ $comment->entity_id }}"
                            style="color: #1e1e1e; font-size: 13px; text-decoration: none; font-style: italic;">
                            <i>Sửa</i>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Form Trả lời (ẩn mặc định) -->
            <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none; margin-top: 15px;">
                <form
                    action="{{ route('comments.reply', ['comment' => $comment->id, 'entity_id' => $comment->entity_id]) }}"
                    method="POST">
                    @csrf
                    <textarea name="content" rows="2" placeholder="Viết câu trả lời..."
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; box-sizing: border-box;">{{ old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span style="color: #e74c3c; font-size: 12px; display: block; margin-top: 5px;">
                            {{ $errors->first('content') }}
                        </span>
                    @endif
                    <input type="hidden" name="entity_id" value="{{ $comment->entity_id }}">
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
                <div class="update-form" id="update-form-{{ $comment->id }}" style="display: none; margin-top: 15px;">
                    <form
                        action="{{ route('comments.update', ['comment' => $comment->id, 'entity_id' => $comment->entity_id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="content" rows="2" placeholder="Chỉnh sửa bình luận..."
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; box-sizing: border-box;">{{ $comment->content }}</textarea>
                        @if ($errors->has('content'))
                            <span style="color: #e74c3c; font-size: 12px; display: block; margin-top: 5px;">
                                {{ $errors->first('content') }}
                            </span>
                        @endif
                        <input type="hidden" name="entity_id" value="{{ $comment->entity_id }}">
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

            <!-- Bình luận con -->
            @if ($comment->replies->count() > 0)
                <div class="replies" style="margin-top: 15px; padding-left: 30px; border-left: 2px solid #f0f0f0;">
                    @foreach ($comment->replies as $reply)
                        @include('client.partials.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
