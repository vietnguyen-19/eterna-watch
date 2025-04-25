<footer id="footer" class="footer footer_type_1 dark">
    <div class="footer-top container py-0">
        <div class="service-promotion horizontal container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-md-0 d-flex align-items-center justify-content-md-center gap-3">
                    <div class="service-promotion__icon">
                        <svg width="52" height="52" viewBox="0 0 52 52" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_shipping" />
                        </svg>
                    </div>
                    <div class="service-promotion__content-wrap">
                        <h3 class="service-promotion__title h6 text-uppercase text-white fw-semi-bold mb-1">
                            Giao Hàng Nhanh & Miễn Phí
                        </h3>
                        <p class="service-promotion__content text-secondary text-white fs-13 mb-0">
                            Miễn phí vận chuyển cho tất cả đơn hàng trên 2.000.000VND
                        </p>
                    </div>
                </div><!-- /.col-md-4 text-center-->

                <div class="col-md-4 mb-5 mb-md-0 d-flex align-items-center justify-content-md-center gap-3">
                    <div class="service-promotion__icon">
                        <svg width="53" height="52" viewBox="0 0 53 52" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_headphone" />
                        </svg>
                    </div>
                    <div class="service-promotion__content-wrap">
                        <h3 class="service-promotion__title h6 text-uppercase text-white fw-semi-bold mb-1">
                            Hỗ Trợ Khách Hàng 24/7
                        </h3>
                        <p class="service-promotion__content text-secondary text-white fs-13 mb-0">
                            Dịch vụ hỗ trợ khách hàng thân thiện 24/7
                        </p>
                    </div>
                </div><!-- /.col-md-4 text-center-->

                <div class="col-md-4 mb-5 mb-md-0 d-flex align-items-center justify-content-md-center gap-3">
                    <div class="service-promotion__icon">
                        <svg width="52" height="52" viewBox="0 0 52 52" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_shield" />
                        </svg>
                    </div>
                    <div class="service-promotion__content-wrap">
                        <h3 class="service-promotion__title h6 text-uppercase text-white fw-semi-bold mb-1">
                            Đảm Bảo Hoàn Tiền
                        </h3>
                        <p class="service-promotion__content text-secondary text-white fs-13 mb-0">
                            Hoàn tiền trong vòng 30 ngày
                        </p>
                    </div>
                </div><!-- /.col-md-4 text-center-->

            </div><!-- /.row -->
        </div><!-- /.service-promotion container -->
    </div><!-- /.footer-top container -->

    <div class="footer-middle container py-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
            <!-- Logo + Info -->
            <div class="footer-column footer-store-info col">
                <div class="logo mb-5">
                    <a href="index.html">
                        <img src="{{ Storage::url($settings['logo_url'] ?? 'default/logo.png') }}" alt="Logo" class="logo__image w-75">
                    </a>
                </div>
                <p class="footer-address fs-14 mb-1">{{ $settings['company_address'] ?? 'Chưa cập nhật địa chỉ' }}</p>
                <p class="fs-14 mb-1"><strong>{{ $settings['company_email'] ?? 'Chưa cập nhật email' }}</strong></p>
                <p class="fs-14"><strong>{{ $settings['company_phone'] ?? 'Chưa cập nhật phone' }}</strong></p>

                <ul class="social-links list-unstyled d-flex flex-wrap gap-2 mt-3">
                    <li><a href="{{ $settings['facebook_link'] ?? '#' }}" class="footer__social-link d-block"><svg class="svg-icon" width="16" height="16"><use href="#icon_facebook" /></svg></a></li>
                    <li><a href="{{ $settings['twitter_link'] ?? '#' }}" class="footer__social-link d-block"><svg class="svg-icon" width="16" height="16"><use href="#icon_twitter" /></svg></a></li>
                    <li><a href="{{ $settings['instagram_link'] ?? '#' }}" class="footer__social-link d-block"><svg class="svg-icon" width="16" height="16"><use href="#icon_instagram" /></svg></a></li>
                    <li><a href="#" class="footer__social-link d-block"><svg class="svg-icon" width="16" height="16"><use href="#icon_youtube" /></svg></a></li>
                    <li><a href="#" class="footer__social-link d-block"><svg class="svg-icon" width="16" height="16"><use href="#icon_pinterest" /></svg></a></li>
                </ul>
            </div>

            <!-- Menu: Công ty -->
            <div class="footer-column footer-menu col">
                <h6 class="text-uppercase fw-bold mb-3">Công Ty</h6>
                <ul class="list-unstyled">
                    <li><a href="{{route('client.about_us')}}" class="menu-link fs-14">Về Eterna</a></li>
                    <li><a href="{{route('client.blog')}}" class="menu-link fs-14">Bài viết</a></li>
                    <li><a href="{{route('client.contact_us')}}" class="menu-link fs-14">Liên hệ</a></li>
                    <li><a href="{{route('account.order')}}" class="menu-link fs-14">Tài khoản của tôi</a></li>
                    <li><a href="{{route('client.privacy')}}" class="menu-link fs-14">Chính sách & pháp lý</a></li>
                    <li><a href="{{route('client.return-policy')}}" class="menu-link fs-14">Chính sách hoàn hàng</a></li>
                </ul>
            </div>

            <!-- Menu: Cửa hàng -->
            <div class="footer-column footer-menu col">
                <h6 class="text-uppercase fw-bold mb-3">Cửa Hàng</h6>
                <ul class="list-unstyled">
                    @foreach ($categories as $category)
                        <li><a href="{{ route('client.shop', ['category_id' => $category->id]) }}" class="menu-link fs-14">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 py-3 border-top border-secondary fs-13">
        © {{ date('Y') }} Eterna. All rights reserved.
    </div>
</footer>

<!-- Mobile Fixed Footer -->
<footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
    <div class="row text-center">
        <div class="col-4">
            <a href="https://uomo-html.flexkitux.com/"
                class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_home" />
                </svg>
                <span>Home</span>
            </a>
        </div><!-- /.col-3 -->

        <div class="col-4">
            <a href="https://uomo-html.flexkitux.com/"
                class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_hanger" />
                </svg>
                <span>Shop</span>
            </a>
        </div><!-- /.col-3 -->

        <div class="col-4">
            <a href="https://uomo-html.flexkitux.com/"
                class="footer-mobile__link d-flex flex-column align-items-center">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_heart" />
                    </svg>
                    <span class="wishlist-amount d-block position-absolute js-wishlist-count">3</span>
                </div>
                <span>Wishlist</span>
            </a>
        </div><!-- /.col-3 -->
    </div><!-- /.row -->
</footer><!-- /.footer-mobile container position-fixed d-md-none bottom-0 -->
