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

    <div class="footer-middle container">
        <div class="row row-cols-lg-5 row-cols-2">
            <div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="index.html">
                        <img width="90%" src="{{ Storage::url($settings['logo_url']) }}" alt="Uomo"
                            class="logo__image d-block">
                    </a>
                </div><!-- /.logo -->
                <p class="footer-address fs-13">{{ $settings['company_address'] }}</p>

                <p class="m-0">
                    <strong class="fw-normal fs-13">{{ $settings['company_email'] }}</strong>
                </p>
                <p>
                    <strong class="fw-normal fs-13">{{ $settings['company_phone'] }}</strong>
                </p>

                <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                    <li>
                        <a href="{{ $settings['facebook_link'] }}" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_facebook" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $settings['twitter_link'] }}" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_twitter" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $settings['instagram_link'] }}" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_instagram" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_pinterest" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div><!-- /.footer-column -->

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase fw-semi-bold">Công ty</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="about.html" class="menu-link menu-link_us-s fs-13">Về Eterna</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s fs-13">Tuyển dụng</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s fs-13">Đối tác liên
                            kết</a></li>
                    <li class="sub-menu__item"><a href="blog_list1.html" class="menu-link menu-link_us-s fs-13">Bài
                            viết</a></li>
                    <li class="sub-menu__item"><a href="contact.html" class="menu-link menu-link_us-s fs-13">Liên
                            hệ</a></li>
                </ul>
            </div><!-- /.footer-column -->

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase fw-semi-bold">Cửa hàng</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="shop2.html" class="menu-link menu-link_us-s fs-13">Sản phẩm
                            mới</a></li>
                    <li class="sub-menu__item"><a href="shop3.html" class="menu-link menu-link_us-s fs-13">Phụ
                            kiện</a></li>
                    <li class="sub-menu__item"><a href="shop4.html" class="menu-link menu-link_us-s fs-13">Nam</a>
                    </li>
                    <li class="sub-menu__item"><a href="shop5.html" class="menu-link menu-link_us-s fs-13">Nữ</a>
                    </li>
                    <li class="sub-menu__item"><a href="shop1.html" class="menu-link menu-link_us-s fs-13">Xem tất
                            cả</a></li>
                </ul>
            </div><!-- /.footer-column -->

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase fw-semi-bold">Hỗ trợ</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="about.html" class="menu-link menu-link_us-s fs-13">Dịch vụ
                            khách hàng</a></li>
                    <li class="sub-menu__item"><a href="account_dashboard.html"
                            class="menu-link menu-link_us-s fs-13">Tài khoản của tôi</a></li>
                    <li class="sub-menu__item"><a href="store_location.html"
                            class="menu-link menu-link_us-s fs-13">Tìm cửa hàng</a></li>
                    <li class="sub-menu__item"><a href="about.html" class="menu-link menu-link_us-s fs-13">Quyền
                            riêng tư và pháp lý</a></li>
                    <li class="sub-menu__item"><a href="about.html" class="menu-link menu-link_us-s fs-13">Thẻ quà
                            tằng</a></li>
                </ul>
            </div><!-- /.footer-column -->

            <div class="footer-column footer-newsletter col-12 mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase fw-semi-bold">Đăng kí</h6>
                <p class="fs-13">Hãy là người đầu tiên nhận tin tức mới nhất về xu hướng, khuyến mãi và nhiều hơn nữa!
                </p>
                <form action="https://uomo-html.flexkitux.com/Demo19/index.html"
                    class="footer-newsletter__form position-relative bg-body">
                    <input class="form-control border-white" type="email" name="email"
                        placeholder="Địa chỉ email của bạn">
                    <input class="btn-link fw-medium bg-white position-absolute top-0 end-0 h-100" type="submit"
                        value="Tham gia">
                </form>
            </div><!-- /.footer-column -->
        </div><!-- /.row-cols-5 -->
    </div><!-- /.footer-middle container -->

    <div class="footer-bottom container">
        <div class="d-block d-md-flex align-items-center">
            <span class="footer-copyright me-auto fs-13">©2024 Uomo</span>
            <div class="footer-settings d-block d-md-flex align-items-center">
                <div class="d-flex align-items-center">
                    <label for="footerSettingsLanguage" class="me-2 text-secondary fs-13 text-white">Language</label>
                    <select id="footerSettingsLanguage"
                        class="form-select form-select-sm bg-transparent fs-13 border-0"
                        aria-label="Default select example" name="store-language">
                        <option class="footer-select__option" selected>United Kingdom | English</option>
                        <option class="footer-select__option" value="1">United States | English</option>
                        <option class="footer-select__option" value="2">German</option>
                        <option class="footer-select__option" value="3">French</option>
                        <option class="footer-select__option" value="4">Swedish</option>
                    </select>
                </div>

                <div class="d-flex align-items-center">
                    <label for="footerSettingsCurrency"
                        class="ms-md-3 me-2 text-secondary fs-13 text-white">Currency</label>
                    <select id="footerSettingsCurrency"
                        class="form-select form-select-sm bg-transparent fs-13 border-0"
                        aria-label="Default select example" name="store-language">
                        <option class="footer-select__option" selected>$ USD</option>
                        <option class="footer-select__option" value="1">£ GBP</option>
                        <option class="footer-select__option" value="2">€ EURO</option>
                    </select>
                </div>
            </div><!-- /.footer-settings -->
        </div><!-- /.d-flex -->
    </div><!-- /.footer-bottom container -->
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
