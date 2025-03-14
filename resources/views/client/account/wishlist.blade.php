@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Wishlist</h2>
            <div class="row">
                <div class="col-lg-3">
                    <ul class="account-nav">
                        <li><a href="./account_dashboard.html" class="menu-link menu-link_us-s">Dashboard</a></li>
                        <li><a href="./account_orders.html" class="menu-link menu-link_us-s">Orders</a></li>
                        <li><a href="./account_edit_address.html" class="menu-link menu-link_us-s">Addresses</a></li>
                        <li><a href="./account_edit.html" class="menu-link menu-link_us-s">Account Details</a></li>
                        <li><a href="./account_wishlist.html" class="menu-link menu-link_us-s menu-link_active">Wishlist</a>
                        </li>
                        <li><a href="./login_register.html" class="menu-link menu-link_us-s">Logout</a></li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__wishlist">
                        <div class="products-grid row row-cols-2 row-cols-lg-3" id="products-grid">
                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-910c4f8cf211073e26"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_5-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_5.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_5-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_5.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-910c4f8cf211073e26"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button" aria-label="Next slide"
                                                aria-controls="swiper-wrapper-910c4f8cf211073e26"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Colorful Jacket</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$29</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-510d10519c106a4b434"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_6-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_6.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_6-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_6.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-510d10519c106a4b434"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button"
                                                aria-label="Next slide"
                                                aria-controls="swiper-wrapper-510d10519c106a4b434"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Shirt In Botanical Cheetah Print</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$62</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-752c54755f72f6410"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_7-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_7.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_7-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_7.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-752c54755f72f6410"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button"
                                                aria-label="Next slide"
                                                aria-controls="swiper-wrapper-752c54755f72f6410"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Cotton Jersey T-Shirt</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$17</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-4d31094ec46d6fed6"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_8-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_8.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_8-1.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_8.jpg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-4d31094ec46d6fed6"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button"
                                                aria-label="Next slide"
                                                aria-controls="swiper-wrapper-4d31094ec46d6fed6"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Zessi Dresses</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price price-old">$129</span>
                                            <span class="money price price-sale">$99</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-4ea82e33da98499b"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_9-1.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_9.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_9-1.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_9.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-4ea82e33da98499b"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button"
                                                aria-label="Next slide"
                                                aria-controls="swiper-wrapper-4ea82e33da98499b"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Cropped Faux Leather Jacket</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$29</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card-wrapper">
                                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <div class="swiper-container background-img js-swiper-slider swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events"
                                            data-settings="{&quot;resizeObserver&quot;: true}">
                                            <div class="swiper-wrapper" id="swiper-wrapper-4566ac76252cb84b"
                                                aria-live="polite"
                                                style="transform: translate3d(-210px, 0px, 0px); transition-duration: 0ms;">
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next"
                                                    data-swiper-slide-index="1" role="group" aria-label="1 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_10-1.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                                <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                                    role="group" aria-label="2 / 4" style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_10.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-next swiper-slide-duplicate-prev"
                                                    data-swiper-slide-index="1" role="group" aria-label="3 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_10-1.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div><!-- /.pc__img-wrapper -->
                                                <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active"
                                                    data-swiper-slide-index="0" role="group" aria-label="4 / 4"
                                                    style="width: 210px;">
                                                    <img loading="lazy" src="../images/products/product_10.jpeg"
                                                        width="330" height="400" alt="Cropped Faux leather Jacket"
                                                        class="pc__img">
                                                </div>
                                            </div>
                                            <span class="pc__img-prev" tabindex="0" role="button"
                                                aria-label="Previous slide"
                                                aria-controls="swiper-wrapper-4566ac76252cb84b"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_prev_sm"></use>
                                                </svg></span>
                                            <span class="pc__img-next" tabindex="0" role="button"
                                                aria-label="Next slide"
                                                aria-controls="swiper-wrapper-4566ac76252cb84b"><svg width="7"
                                                    height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_next_sm"></use>
                                                </svg></span>
                                            <span class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                        </div>
                                        <button class="btn-remove-from-wishlist">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_close"></use>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title">Calvin Shorts</h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$62</span>
                                        </div>

                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.products-grid row -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
@endsection
@section('style')
@endsection
