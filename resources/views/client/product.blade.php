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
                            <a style="font-weight:500" href="{{ route('client.home') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Trang chủ</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a style="font-weight:500" href="{{ route('client.shop') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Cửa hàng</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                            @php
                                // Lấy ID của sản phẩm trước và sau
                                $productTruoc = \App\Models\Product::where('id', '<', $product->id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                $productSau = \App\Models\Product::where('id', '>', $product->id)
                                    ->orderBy('id', 'asc')
                                    ->first();
                            @endphp

                            @if ($productTruoc)
                                <a href="{{ route('client.shop.show', $productTruoc->id) }}"
                                    class="text-uppercase fw-medium">
                                    <svg class="mb-1px" width="10" height="10" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_md" />
                                    </svg>
                                    <span class="menu-link menu-link_us-s">Trước đó</span>
                                </a>
                            @endif

                            @if ($productSau)
                                <a href="{{ route('client.shop.show', $productSau->id) }}" class="text-uppercase fw-medium">
                                    <span class="menu-link menu-link_us-s">Tiếp theo</span>
                                    <svg class="mb-1px" width="10" height="10" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_md" />
                                    </svg>
                                </a>
                            @endif

                        </div><!-- /.shop-acs -->
                    </div>

                    <h1 class="product-single__name">{{ $product->name }}</h1>

                    <div class="product-single__price">
                        <span class="current-price"></span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    <form name="addtocart-form" method="post">
                        <div class="product-single__swatches">


                            <div id="product-variants" data-variants='@json($variants)'></div>
                            @if ($product->type == 'variant')
                                <input id="variant_id" name="variant_id" hidden>
                                @foreach ($product->attributes as $attribute)
                                    <div class="product-swatch text-swatches">
                                        <label><strong>{{ $attribute->attribute_name }}</strong></label>
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
                            @else
                                @if ($product->stock > 0)
                                    <p style="margin-bottom: 0.5rem;">
                                        <span style="font-weight: 600; font-size: 20px; color: #000;">
                                            Giá:
                                        </span>
                                        <span style="font-weight: 700; font-size: 26px; color: #dc3545; margin-left: 6px;">
                                            {{ number_format($product->price_default, 0, ',', '.') }}₫
                                        </span>
                                        <small style="color: #198754; margin-left: 10px; font-size: 15px;">
                                            (Còn {{ $product->current_stock }} sản phẩm)
                                        </small>
                                    </p>
                                @else
                                    <p style="margin-bottom: 0.5rem;">
                                        <span style="font-weight: 600; font-size: 20px; color: #000;">
                                            Giá:
                                        </span>
                                        <span style="font-weight: 700; font-size: 26px; color: #6c757d; margin-left: 6px;">
                                            Hết hàng
                                        </span>
                                    </p>
                                @endif
                            @endif
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
                            @if ($product->type == 'simple')
                                <input id="variant_id" name="variant_id" value="{{ $product->getFirstVariantId() }}"
                                    hidden>
                                <input id="product_type" name="product_type" value="{{ $product->type }}" hidden>
                                <button type="submit" class="btn btn-primary btn-addtocart simple">Thêm vào giỏ
                                    hàng</button>
                            @else
                                <button type="submit" class="btn btn-primary btn-addtocarts">Thêm vào giỏ hàng</button>
                            @endif

                            <a id="view_cart" style="padding: 1.2rem; background:rgb(50, 152, 159)"
                                href="{{ route('cart.index') }}" class="d-none">
                                <svg class="d-block text-white" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_cart"></use>
                                </svg>
                            </a>

                        </div>
                    </form>
                    <div class="product-single__meta-info">
                        <div class="meta-item">
                            <label>Thường hiệu:</label>
                            <span>{{ $product->brand->name }}</span>
                        </div>

                        <div class="meta-item">
                            <label>Danh mục:</label>
                            <span>{{ $product->category->name }}</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="product-single__details-tab">
                <div class="" id="tab-reviews">
                    <h2 style="border-left: 5px solid rgb(204, 1, 1); padding-left:8px"
                        class="product-single__reviews-title"><strong>MÔ TẢ SẢN PHẨM</strong></h2>

                    <div class="product-single__description">
                        <p>{!! $product->full_description !!}</p>

                    </div>

                </div>
                <div class="mb-md-2 pb-md-5"></div>
                <div class="card px-5 py-3">
                    <div style="width:100%" id="tab-reviews">
                        <h2 class="product-single__reviews-title text-center">
                            <button
                                class="btn w-100 d-flex justify-content-between align-items-center fs-5 py-3 px-4 border rounded"
                                type="button" data-bs-toggle="collapse" data-bs-target="#commentList"
                                aria-expanded="true" aria-controls="commentList">
                                <strong><i class="fa-solid fa-comments text-primary me-2"></i> BÌNH LUẬN SẢN PHẨM</strong>
                                <i class="fa-solid fa-angle-up" title="Mở hoặc đóng bình luận"></i>
                            </button>
                        </h2>
                        <div class="collapse show " id="commentList">
                            <div class="accordion" id="commentAccordion">
                                @if ($comments->isEmpty())
                                    <div class="text-center text-muted">
                                        <i class="fas fa-comments fa-lg me-2 mb-5"></i> Chưa có đánh giá nào cho sản phẩm
                                        này.
                                    </div>
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
                                    <div class="notification-container"></div>
                                    <div style="border:1px solid rgb(189, 189, 189)" class="rating-summary mb-4 p-4">
                                        <h5>Đánh giá sản phẩm</h5>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong style="font-size: 2rem;">{{ $ratingSummary['average'] }}</strong>
                                            <div class="ms-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="bi bi-star{{ $i <= round($ratingSummary['average']) ? '-fill text-warning' : '' }}"></i>
                                                @endfor
                                                <div>{{ $ratingSummary['total'] }} lượt đánh giá</div>
                                            </div>
                                        </div>

                                        @for ($i = 5; $i >= 1; $i--)
                                            @php
                                                $count = $ratingSummary['stars'][$i];
                                                $percent =
                                                    $ratingSummary['total'] > 0
                                                        ? round(($count / $ratingSummary['total']) * 100)
                                                        : 0;
                                            @endphp
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-1" style="width: 50px;">{{ $i }} sao</span>
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar"
                                                        style="background: rgb(255, 179, 0);width: {{ $percent }}%;"></div>
                                                </div>
                                                <span>{{ $count }}</span>
                                            </div>
                                        @endfor
                                    </div>

                                    <div class="" style="width:100%; margin: 0 auto;">
                                        @foreach ($comments as $comment)
                                            <div id="comment-container-{{ $comment->id }}"
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
                                                                <span
                                                                    style="font-size: 12px; color: #888; font-weight: normal;">
                                                                    | {{ $comment->created_at->format('F d, Y') }}
                                                                </span>
                                                            </h6>
                                                        </div>

                                                        <!-- Đánh giá sao -->
                                                        <div class="reviews-group" id="reviews-group-{{ $comment->id }}"
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
                                                            <p id="comment-content-{{ $comment->id }}"
                                                                style="margin: 0;">
                                                                {{ $comment->content }}</p>
                                                        </div>


                                                        <!-- Nút trả lời -->
                                                        {{-- <div class="review-actions"
                                                            style="display: flex; gap: 15px; margin-top: 8px;">
                                                            <!-- Nút Trả lời -->
                                                            @if ($comment->user_id !== Auth::id())
                                                                <div class="review-action">
                                                                    <a href="#" class="reply-btn"
                                                                        data-comment-id="{{ $comment->id }}"
                                                                        data-entity-id="{{ $comment->entity_id }}"
                                                                        style="color: #3c6ae7; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                        <i>Trả lời</i>
                                                                    </a>
                                                                </div>
                                                            @endif

                                                            <!-- Nút Xóa và Sửa (chỉ hiển thị nếu bình luận thuộc về người dùng hiện tại) -->
                                                            @if (Auth::check() && Auth::id() === $comment->user_id)
                                                                <!-- Nút Xóa -->
                                                                <div class="review-action">
                                                                    <a href="#" class="update-btn"
                                                                        data-comment-id="{{ $comment->id }}"
                                                                        style="color: #1e1e1e; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                        <i>Sửa</i>
                                                                    </a>
                                                                </div>
                                                                <div class="review-action">
                                                                    <a href="#" class="delete-btn"
                                                                        data-comment-id="{{ $comment->id }}"
                                                                        data-comment-id="{{ $comment->id }}"
                                                                        style="color: #e74c3c; font-size: 13px; text-decoration: none; font-style: italic;">
                                                                        <i>Xóa</i>
                                                                    </a>
                                                                </div>

                                                                <!-- Nút Sửa -->
                                                            @endif
                                                        </div> --}}

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
                                                                        style="color: #3c47e7; font-size: 12px; display: block; margin-top: 5px;">
                                                                        {{ $errors->first('content') }}
                                                                    </span>
                                                                @endif
                                                                <input type="hidden" name="entity_id"
                                                                    value="{{ $comment->entity_id }}">
                                                                <input type="hidden" name="entity_type"
                                                                    value="{{ $comment->entity_type }}">
                                                                <div style="display: flex; gap: 10px; margin-top: 8px;">
                                                                    <button type="submit"
                                                                        style="background: #3c47e7; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
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
                                                                style="display: none; margin-top: 15px; width:100%">
                                                                <form id="comment-update-form-{{ $comment->id }}">
                                                                    @csrf
                                                                    @if ($comment->parent_id === null && $comment->entity_type === 'product')
                                                                        <div style="margin-top: 8px;">
                                                                            <span><strong>Đánh giá</strong></span>
                                                                            <div class="star-rating my-2"
                                                                                data-comment-id="{{ $comment->id }}"
                                                                                data-rating="{{ $comment->rating }}">
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <i class="fa fa-star star {{ $i <= $comment->rating ? 'active' : '' }}"
                                                                                        data-value="{{ $i }}"></i>
                                                                                @endfor
                                                                            </div>
                                                                            <input class="update-rating" name="rating"
                                                                                type="hidden"
                                                                                id="form-input-rating-{{ $comment->id }}"
                                                                                value="{{ $comment->rating }}">
                                                                        </div>
                                                                    @endif
                                                                    <textarea name="content" class="update-content" data-id="{{ $comment->id }}" rows="2"
                                                                        placeholder="Chỉnh sửa bình luận..."
                                                                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; box-sizing: border-box;">{{ $comment->content }}</textarea>

                                                                    @error('content')
                                                                        <span
                                                                            style="color: #e74c3c; font-size: 12px; display: block; margin-top: 5px;">
                                                                            {{ $message }}
                                                                        </span>
                                                                    @enderror



                                                                    <div
                                                                        style="display: flex; gap: 10px; margin-top: 8px;">
                                                                        <button type="button" class="save-update"
                                                                            data-id="{{ $comment->id }}"
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
                        <div class="product-single__review-form mt-4">
                            {{-- <form class="" method="POST" action="{{ route('comments.store', $product->id) }}">
                                @csrf
                                <h5><strong>Đánh giá sản phẩm "{{ $product->name }}"</strong></h5>
                                <p>Bạn cần đăng nhập và mua sản phẩm để đánh giá khách quan *</p>
                                @if ($errors->any())
                                    <div style="border-radius: 5px" class="alert alert-danger alert-dismissible fade show"
                                        role="alert">
                                        <strong>⚠ Có lỗi xảy ra:</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

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
                                <input type="hidden" value="product" name="entity_type">
                                <div class="mb-4">
                                    <textarea name="content" id="form-input-review" class="form-control form-control_gray"
                                        placeholder="Đánh giá của bạn" cols="30" rows="8"></textarea>
                                </div>

                                <div class="form-label-fixed mb-4">
                                    <button type="submit" class="btn btn-primary">Gửi bình luận và đánh giá</button>
                                </div>
                            </form> --}}
                        </div>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addToCartForm = document.querySelector("form[name='addtocart-form']");
            const viewCartButton = document.getElementById("view_cart");

            const btnSimple = document.querySelector(".btn.btn-primary.btn-addtocart.simple");
            const btnVariable = document.querySelector(".btn-addtocarts");

            // Kiểm tra người dùng đã đăng nhập chưa
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            // Hàm hiển thị thông báo đăng nhập
            function showLoginAlert() {
                // Lưu URL hiện tại vào sessionStorage
                sessionStorage.setItem('redirectUrl', window.location.href);

                Swal.fire({
                    icon: 'warning',
                    title: 'Bạn chưa đăng nhập!',
                    text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.',
                    confirmButtonText: 'Đăng nhập'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Chuyển hướng đến trang đăng nhập
                        window.location.href = "{{ route('client.login') }}";
                    }
                });
            }

            // Hàm xử lý thêm vào giỏ hàng
            function addToCartHandler() {
                if (!isLoggedIn) {
                    showLoginAlert();
                    return;
                }

                let formData = new FormData(addToCartForm);

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
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã thêm vào giỏ hàng!',
                                // timer: 3000,
                                // showConfirmButton: false
                            });
                            viewCartButton.classList.remove("d-none");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                    });
            }

            // Xử lý cho sản phẩm simple
            if (btnSimple) {
                btnSimple.addEventListener("click", function(event) {
                    event.preventDefault(); // Ngăn reload
                    addToCartHandler(); // Gọi hàm xử lý chung
                });
            }

            // Xử lý cho sản phẩm có biến thể
            if (btnVariable) {
                btnVariable.addEventListener("click", function(event) {
                    event.preventDefault(); // Ngăn reload

                    if (!isLoggedIn) {
                        showLoginAlert();
                        return;
                    }

                    const variantIdInput = document.getElementById("variant_id");

                    if (!variantIdInput.value) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Chưa chọn biến thể!',
                            text: 'Vui lòng chọn biến thể trước khi thêm vào giỏ hàng.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    addToCartHandler(); // Gọi hàm xử lý chung
                });
            }
        });
    </script>


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
        $(document).ready(function() {
            $(document).on("click", ".reply-btn, .update-btn", function(e) {
                e.preventDefault();
                let commentId = $(this).data("comment-id");
                let targetForm = $(this).hasClass("reply-btn") ? "#reply-form-" + commentId :
                    "#update-form-" + commentId;

                // Nếu form đang ẩn, mở nó ra và ẩn các form khác
                if ($(targetForm).css("display") === "none") {
                    $(".reply-form, .update-form").hide(); // Ẩn tất cả form khác
                    $(targetForm).show().find("textarea").focus(); // Hiển thị form được chọn
                } else {
                    $(targetForm).hide(); // Nếu đang mở thì ẩn đi
                }
            });
            // Ẩn form khi bấm "Hủy" (Và đảm bảo có thể mở lại)
            $(document).on("click", ".cancel-reply, .cancel-update", function() {
                $(this).closest(".reply-form, .update-form").hide();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".save-update").click(function() {
                let commentId = $(this).data("id");
                let content = $("#update-form-" + commentId + " .update-content").val();
                let rating = $("#update-form-" + commentId + " .update-rating").val() || null;

                $.ajax({
                    url: "/comments/update/" + commentId,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        content: content,
                        rating: rating
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#comment-content-" + commentId).text(response.comment.content);
                            let starsContainer = $("#reviews-group-" + commentId).empty();
                            if (response.comment.rating !== null) {
                                for (let i = 0; i < response.comment.rating; i++) {
                                    starsContainer.append(`<svg class="review-star" viewBox="0 0 9 9" style="width: 14px; height: 14px; fill: #ffc107;">
                                    <use href="#icon_star" /></svg>`);
                                }
                            }
                            $("#update-form-" + commentId).hide();
                            showNotification("success",
                                "Bình luận đã được cập nhật thành công!");
                        } else {
                            showNotification("error", "Đã có lỗi xảy ra!");
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        showNotification("error", errors?.content ? errors.content[0] :
                            "Lỗi không xác định!");
                    }
                });
            });

            // Xóa bình luận
            $(".delete-btn").click(function(e) {
                e.preventDefault();
                let commentId = $(this).data("comment-id");
                if (!confirm("Bạn có chắc chắn muốn xóa bình luận này?")) return;

                $.ajax({
                    url: "/comments/delete/" + commentId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification("success", "Bình luận đã được xóa thành công!");
                            $("#comment-container-" + commentId).fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            showNotification("error", "Đã có lỗi xảy ra!");
                        }
                    },
                    error: function() {
                        showNotification("error", "Đã có lỗi xảy ra!");
                    }
                });
            });

            // Hàm hiển thị thông báo
            function showNotification(type, message) {
                let alertBox = `<div class="alert ${type === "success" ? "alert-success" : "alert-error"}"
                style="display: flex; align-items: center; padding: 8px 12px; margin-bottom: 12px; border-radius: 4px; font-size: 14px;
                background: ${type === "success" ? "#e6ffe6" : "#ffe6e6"}; color: ${type === "success" ? "#2e7d32" : "#d32f2f"};">
                <i class="fas ${type === "success" ? "fa-check-circle" : "fa-exclamation-circle"}" style="margin-right: 8px;"></i> ${message}
            </div>`;

                $(".notification-container").html(alertBox).fadeIn();
                setTimeout(() => $(".notification-container").fadeOut("slow", function() {
                    $(this).empty().show();
                }), 3000);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".star-rating").forEach(function(ratingElement) {
                let stars = ratingElement.querySelectorAll(".star");
                let inputRating = document.getElementById("form-input-rating-" + ratingElement.dataset
                    .commentId);
                let currentRating = parseInt(ratingElement.dataset.rating) || 0;

                // Đánh dấu số sao hiện tại
                stars.forEach((star, index) => {
                    if (index < currentRating) {
                        star.classList.add("active");
                    }
                });

                // Xử lý sự kiện click để chọn đánh giá
                stars.forEach(function(star, index) {
                    star.addEventListener("click", function() {
                        let ratingValue = index + 1;
                        inputRating.value =
                            ratingValue; // Cập nhật giá trị vào input hidden

                        // Reset tất cả sao
                        stars.forEach(s => s.classList.remove("active"));

                        // Tô vàng các sao đã chọn
                        for (let i = 0; i <= index; i++) {
                            stars[i].classList.add("active");
                        }
                    });

                    // Hiệu ứng hover
                    star.addEventListener("mouseover", function() {
                        stars.forEach(s => s.classList.remove("hover"));
                        for (let i = 0; i <= index; i++) {
                            stars[i].classList.add("hover");
                        }
                    });

                    star.addEventListener("mouseleave", function() {
                        stars.forEach(s => s.classList.remove("hover"));
                    });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
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

        .star-rating {
            display: flex;
            gap: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .star {
            color: #ccc;
            transition: color 0.3s;
        }

        .star:hover,
        .star.active {
            color: #ffcc00;
            /* Màu vàng giống Shopee */
        }
    </style>
@endsection
