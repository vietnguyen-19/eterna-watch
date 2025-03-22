@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="674" height="674" alt="">
                                        <a data-fancybox="gallery"
                                            href="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>
                                    @foreach ($product->variants as $variant)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ Storage::url($variant->image ?? 'avatar/default.jpeg') }}"
                                                width="674" height="674" alt="">
                                            <a data-fancybox="gallery"
                                                href="{{ Storage::url($variant->image ?? 'avatar/default.jpeg') }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></div>
                                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="104" height="104" alt=""></div>
                                    @foreach ($product->variants as $variant)
                                        <div class="swiper-slide product-single__image-item"><img loading="lazy"
                                                class="h-auto"
                                                src="{{ Storage::url($variant->image ?? 'avatar/default.jpeg') }}"
                                                width="104" height="104" alt=""></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a style="font-weight:500" href="#"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a style="font-weight:500" href="#"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                            <a href="product1_simple.html" class="text-uppercase fw-medium"><svg class="mb-1px"
                                    width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_md" />
                                </svg><span class="menu-link menu-link_us-s">Prev</span></a>
                            <a href="product3_external.html" class="text-uppercase fw-medium"><span
                                    class="menu-link menu-link_us-s">Next</span><svg class="mb-1px" width="10"
                                    height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_md" />
                                </svg></a>
                        </div><!-- /.shop-acs -->
                    </div>
                    <h1 class="product-single__name">{{ $product->name }}</h1>
                    <div class="product-single__rating">
                        <div class="reviews-group d-flex">
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_star" />
                            </svg>
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_star" />
                            </svg>
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_star" />
                            </svg>
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_star" />
                            </svg>
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_star" />
                            </svg>
                        </div>
                        <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                    </div>
                    <div class="product-single__price">
                        <span class="current-price"></span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    <form name="addtocart-form" method="post">
                        <div class="product-single__swatches">
                            <input id="variant_id" name="variant_id" hidden>

                            <div id="product-variants" data-variants='@json($variants)'></div>

                            @foreach ($product->attributes as $attribute)
                                <div class="product-swatch text-swatches">
                                    <label>{{ $attribute->attribute_name }}</label>
                                    <div class="swatch-list">
                                        @foreach ($attribute->attributeValues as $value)
                                            <input type="radio" name="attribute_{{ $attribute->id }}"
                                                value="{{ $value->id }}" id="value-{{ $value->id }}">
                                            <label class="swatch" for="value-{{ $value->id }}"
                                                title="{{ $value->note }}">{{ $value->value_name }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Hiển thị giá -->
                            <p id="variant-price" style="display: none; font-size: 1.5rem; font-weight: bold;"></p>
                            <span id="error-message" style="color: red; display: none;" class="mb-2">Không tồn tại sản
                                phẩm</span>
                            <!-- Nút Clear -->
                            <button type="button" id="clear-selection" class="btn btn-sm mb-3"
                                style="display: none; background: rgb(1, 143, 153); color: white;">Clear</button>



                        </div>
                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1"
                                    class="qty-control__number text-center">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div><!-- .qty-control -->
                            <button type="submit" class="btn btn-primary btn-addtocart">Thêm vào giỏ hàng</button>
                            <a id="view_cart" style="padding: 1.2rem; background:rgb(50, 152, 159)"
                                href="{{ route('cart.index') }}" class="d-none">
                                <svg class="d-block text-white" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_cart"></use>
                                </svg>
                            </a>

                        </div>
                    </form>
                    <div class="product-single__addtolinks">
                        <a href="#" class="menu-link menu-link_us-s add-to-wishlist"><svg width="16"
                                height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_heart" />
                            </svg><span>Thêm vào yêu thích</span></a>
                        <share-button class="share-button">
                            <button
                                class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_sharing" />
                                </svg>
                                <span>Share</span>
                            </button>
                            <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                                <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                                <div id="Article-share-template__main"
                                    class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                                    <div class="field grow mr-4">
                                        <label class="field__label sr-only" for="url">Link</label>
                                        <input type="text" class="field__input w-full" id="url"
                                            value="https://uomo-crystal.myshopify.com/blogs/news/go-to-wellness-tips-for-mental-health"
                                            placeholder="Link" onclick="this.select();" readonly="">
                                    </div>
                                    <button class="share-button__copy no-js-hidden">
                                        <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                            focusable="false" viewBox="0 0 11 13">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="sr-only">Copy link</span>
                                    </button>
                                </div>
                            </details>
                        </share-button>
                        <script src="js/details-disclosure.js" defer="defer"></script>
                        <script src="js/share.js" defer="defer"></script>
                    </div>
                    <div class="product-single__meta-info">
                        <div class="meta-item">
                            <label>SKU:</label>
                            <span>{{ $product->category->name }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Danh mục:</label>
                            <span>{{ $product->category->name }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Tags:</label>
                            <span>biker, black, bomber, leather</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-single__details-tab">
                <div class="" id="tab-reviews">
                    <h2 style="border-left: 5px solid rgb(204, 1, 1); padding-left:8px"
                        class="product-single__reviews-title"><strong>MÔ TẢ SẢN PHẨM</strong></h2>

                    <div class="product-single__description">
                        <p>{{ $product->full_description }}</p>
                    </div>

                </div>
                <div class="mb-md-1 pb-md-3"></div>
                <div style="width:100%" id="tab-reviews">
                    <h2 style="border-left: 5px solid rgb(204, 1, 1); padding-left:8px"
                        class="product-single__reviews-title"><strong>BÌNH LUẬN SẢN PHẨM</strong></h2>
                    @if ($comments->isEmpty())
                        <p class="text-muted"><i>Chưa có đánh giá về sản phẩm.</i></p>
                    @else
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
                        <div class="" style="width:100%; margin: 0 auto;">
                            @foreach ($comments as $comment)
                                <div class=""
                                    style="border-bottom: 1px solid #eee; padding: 20px 0;">
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
                                                    <span style="font-size: 12px; color: #888; font-weight: normal;">
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
                                            <div style="width: 100%; font-size: 14px; color: #333; line-height: 1.5;">
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
                                                            method="POST" class="delete-form" style="display: inline;">
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
                                            <div  class="reply-form" id="reply-form-{{ $comment->id }}"
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


                                            <!-- Form trả lời (ẩn mặc định) -->

                                            <!-- Bình luận con -->
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
                    <div class="product-single__review-form mt-4">
                        <form class="" method="POST" action="{{ route('comments.store', $product->id) }}">
                            @csrf
                            <h5><strong>Hãy là người đầu tiên đánh giá sản phẩm "Message Cotton T-Shirt"</strong></h5>
                            <p>Bạn cần đăng nhập và mua sản phẩm để đánh giá khách quan *</p>

                            <div class="select-star-rating">
                                <label>Đánh giá của bạn *</label>
                                <span class="star-rating">
                                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc"
                                        viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                    </svg>
                                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc"
                                        viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                    </svg>
                                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc"
                                        viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                    </svg>
                                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc"
                                        viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                    </svg>
                                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc"
                                        viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                    </svg>
                                </span>
                                <input name="rating" type="hidden" id="form-input-rating" value="">
                            </div>

                            <div class="mb-4">
                                <textarea name="content" id="form-input-review" class="form-control form-control_gray"
                                    placeholder="Đánh giá của bạn" cols="30" rows="8"></textarea>
                            </div>

                            <div class="form-label-fixed mb-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Sản phẩm <strong>liên quan</strong></h2>

            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
                "autoplay": false,
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "effect": "none",
                "loop": true,
                "pagination": {
                  "el": "#related_products .products-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": "#related_products .products-carousel__next",
                  "prevEl": "#related_products .products-carousel__prev"
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 2,
                    "slidesPerGroup": 2,
                    "spaceBetween": 14
                  },
                  "768": {
                    "slidesPerView": 3,
                    "slidesPerGroup": 3,
                    "spaceBetween": 24
                  },
                  "992": {
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "spaceBetween": 30
                  }
                }
              }'>
                    <div class="swiper-wrapper">
                        @foreach ($productRelated as $product)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('client.shop.show', $product->id) }}">
                                        <img loading="lazy"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="330" height="400" alt="Cropped Faux leather Jacket"
                                            class="pc__img">
                                        <img loading="lazy"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="330" height="400" alt="Cropped Faux leather Jacket"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('client.shop.show', $product->id) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div style="color: rgb(188, 0, 0); " class="product-card__price d-flex mb-1 fw-bold">
                                        @if ($product->min_price == $product->max_price)
                                            {{ number_format($product->min_price, 0, ',', '.') }} VND
                                        @else
                                            {{ number_format($product->min_price, 0, ',', '.') }} -
                                            {{ number_format($product->max_price, 0, ',', '.') }} VND
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                <!-- /.products-pagination -->
            </div><!-- /.position-relative -->

        </section><!-- /.products-carousel container -->
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productVariants = document.getElementById("product-variants");
            if (!productVariants) {
                console.error("Không tìm thấy #product-variants trong HTML");
                return;
            }

            const variantData = JSON.parse(productVariants.dataset.variants || "[]");
            if (!Array.isArray(variantData) || variantData.length === 0) {
                console.error("Dữ liệu biến thể không hợp lệ:", variantData);
                return;
            }

            console.log("Dữ liệu biến thể:", variantData);

            const variantPrice = document.getElementById("variant-price");
            const clearBtn = document.getElementById("clear-selection");
            const errorMessage = document.getElementById("error-message");
            const radios = document.querySelectorAll("input[type='radio']");
            const variantIdInput = document.getElementById("variant_id"); // Lấy input hidden

            function updatePrice() {
                let selectedAttributes = [...document.querySelectorAll("input[type='radio']:checked")]
                    .map(input => parseInt(input.value))
                    .filter(value => !isNaN(value));

                console.log("Thuộc tính đã chọn:", selectedAttributes);

                let matchedVariant = variantData.find(variant =>
                    Array.isArray(variant.attributes) &&
                    selectedAttributes.length === variant.attributes.length &&
                    selectedAttributes.sort().toString() === variant.attributes.sort().toString()
                );

                console.log("Biến thể phù hợp:", matchedVariant);

                if (matchedVariant) {
                    variantPrice.innerHTML = `
                ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(parseFloat(matchedVariant.price))}
                <span style="font-size: 14px; color: green; margin-left: 8px;">(Còn ${matchedVariant.quantity} sản phẩm)</span>
            `;

                    variantIdInput.value = matchedVariant.id;
                    variantPrice.style.display = "block";
                    errorMessage.style.display = "none"; // Ẩn lỗi nếu có sản phẩm
                } else {
                    variantPrice.style.display = "none";
                    errorMessage.style.display = selectedAttributes.length ? "block" :
                        "none"; // Hiện lỗi nếu không có sản phẩm
                }

                clearBtn.style.display = selectedAttributes.length ? "block" : "none";
            }

            radios.forEach(radio => radio.addEventListener("change", updatePrice));

            clearBtn.addEventListener("click", function() {
                radios.forEach(radio => radio.checked = false);
                variantPrice.style.display = "none";
                errorMessage.style.display = "none"; // Ẩn lỗi khi reset
                clearBtn.style.display = "none";
            });

            variantPrice.style.display = "none";
            clearBtn.style.display = "none";
            errorMessage.style.display = "none"; // Ẩn ban đầu
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addToCartForm = document.querySelector("form[name='addtocart-form']");
            const viewCartButton = document.getElementById("view_cart");

            addToCartForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Ngăn chặn reload trang

                // Thu thập dữ liệu form
                let formData = new FormData(this);
                // Gửi AJAX request
                fetch("{{ route('cart.add') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Sản phẩm đã được thêm vào giỏ hàng!"); // Thông báo thành công
                            viewCartButton.classList.remove("d-none"); // Hiển thị nút "Xem giỏ hàng"
                        } else {
                            alert("Lỗi: " + data.message); // Hiển thị lỗi nếu có
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
        });
    </script>
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
    <style>
        .reply-form {
            transition: all 0.3s ease;
            /* Hiệu ứng mượt khi hiện/ẩn */
        }

        .reply-btn:hover {
            color: #c0392b;
            /* Đậm hơn khi hover */
        }

        textarea:focus {
            outline: none;
            border-color: #e74c3c;
            /* Viền đỏ khi focus */
        }

        .comment-container {
            width: 100%;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
    </style>
@endsection
