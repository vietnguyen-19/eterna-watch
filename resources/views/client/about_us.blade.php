@extends('client.layouts.master')

@section('content')
    <!-- Hero Section -->
    <div class="spacer py-4 py-xl-5"></div>
    <div class="mb-4 pb-lg-3"></div>
    <section class="hero-section container-fluid py-5 bg-gradient-primary text-white text-center">
        <div class="container py-5">
            <h1 class="display-4 fw-bold mb-4 text-uppercase">EternaWatch</h1>
            <p class="lead mb-4 fs-3">Biểu Tượng Của Sự Đẳng Cấp & Tinh Tế</p>
            <p class="col-md-8 mx-auto text-light opacity-80 fs-5">
                EternaWatch mang đến những tuyệt tác thời gian, kết tinh từ nghệ thuật chế tác và phong cách sống thượng lưu, dành cho những ai trân trọng sự hoàn mỹ.
            </p>
            <a href="#showroom" class="btn btn-outline-light btn-lg mt-4 px-5 py-2">Khám Phá Showroom</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section container py-5 px-4 px-md-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 order-lg-2">
                <div class="image-wrapper position-relative">
                    <img src="https://images.unsplash.com/photo-1708647585535-c3f3317e9088?q=80&w=1930&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="EternaWatch Collection" class="img-fluid rounded-3 shadow-sm">
                    <div class="image-overlay"></div>
                </div>
            </div>
            <div class="col-lg-12 order-lg-1">
                <h2 class="fw-bold mb-4 text-center text-uppercase text-dark">Về EternaWatch</h2>
                <p class="text-muted lead fs-5">
                    Mỗi chiếc đồng hồ là một tác phẩm nghệ thuật, kết hợp kỹ thuật chế tác đỉnh cao và phong cách sống tinh tế.
                </p>
                <p class="text-dark opacity-75">
                    Chúng tôi tự hào mang đến bộ sưu tập từ các thương hiệu huyền thoại như <strong>Rolex</strong>, <strong>Patek Philippe</strong>, <strong>Audemars Piguet</strong>, <strong>Omega</strong>, và <strong>Cartier</strong>. Với đội ngũ chuyên gia tận tâm, EternaWatch cam kết cung cấp sản phẩm chính hãng và trải nghiệm mua sắm đẳng cấp.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision-section container py-5 px-4 px-md-5 bg-secondary rounded-3">
        <div class="row g-4">
            <div class="col-md-6">
                <h3 class="fw-semibold mb-3 text-dark">Sứ Mệnh</h3>
                <p class="text-muted fs-5">
                    Tôn vinh giá trị cá nhân qua những tuyệt tác đồng hồ vượt thời gian, đại diện cho phong cách sống thượng lưu.
                </p>
            </div>
            <div class="col-md-6">
                <h3 class="fw-semibold mb-3 text-dark">Tầm Nhìn</h3>
                <p class="text-muted fs-5">
                    Trở thành điểm đến hàng đầu tại Việt Nam và khu vực, lựa chọn số một của các tín đồ đồng hồ và nhà sưu tầm.
                </p>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="core-values-section container py-5 px-4 px-md-5">
        <h2 class="fw-bold mb-5 text-center text-uppercase text-dark">Giá Trị Cốt Lõi</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="value-card p-4 rounded-3 bg-white shadow-sm">
                    <h5 class="fw-semibold text-dark">Sáng Tạo</h5>
                    <p class="text-muted">Đổi mới trong thiết kế và dịch vụ để tạo nên sự khác biệt.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card p-4 rounded-3 bg-white shadow-sm">
                    <h5 class="fw-semibold text-dark">Uy Tín</h5>
                    <p class="text-muted">Xây dựng niềm tin bền vững qua chất lượng và dịch vụ vượt trội.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card p-4 rounded-3 bg-white shadow-sm">
                    <h5 class="fw-semibold text-dark">Khách Hàng Là Trung Tâm</h5>
                    <p class="text-muted">Đặt trải nghiệm và sự hài lòng của khách hàng lên hàng đầu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="timeline-section container py-5 px-4 px-md-5 bg-secondary rounded-3">
        <h2 class="fw-bold mb-5 text-center text-uppercase text-dark">Hành Trình Phát Triển</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="timeline-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">2018</h5>
                    <p class="text-muted">Khởi nghiệp với ước mơ kiến tạo không gian nghệ thuật.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="timeline-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">2020</h5>
                    <p class="text-muted">Mở showroom đầu tiên tại TP. Hồ Chí Minh.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="timeline-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">2022</h5>
                    <p class="text-muted">Ra mắt hệ thống bán hàng online toàn quốc.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="timeline-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">2024</h5>
                    <p class="text-muted">Hợp tác với các nhà thiết kế nội thất nổi tiếng.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Commitment Section -->
    <section class="commitment-section container py-5 px-4 px-md-5 text-center">
        <h2 class="fw-bold mb-4 text-uppercase text-dark">Cam Kết Của Chúng Tôi</h2>
        <p class="lead col-md-8 mx-auto text-muted fs-4">
            “Mang đến những tuyệt tác đồng hồ chất lượng vượt trội, dịch vụ tận tâm – biến mỗi khoảnh khắc thành biểu tượng của sự hoàn mỹ.”
        </p>
    </section>

    <!-- Showroom Section -->
    <section id="showroom" class="showroom-section container py-5 px-4 px-md-5 bg-secondary rounded-3">
        <h2 class="fw-bold mb-5 text-center text-uppercase text-dark">Hệ Thống Showroom</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="showroom-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">TP. Hồ Chí Minh</h5>
                    <p class="text-muted">123 Lý Tự Trọng, Quận 1</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="showroom-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">Hà Nội</h5>
                    <p class="text-muted">456 Trần Duy Hưng, Cầu Giấy</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="showroom-card p-4 rounded-3 bg-white shadow-sm text-center">
                    <h5 class="fw-semibold text-dark">Đà Nẵng</h5>
                    <p class="text-muted">789 Nguyễn Văn Linh</p>
                </div>
            </div>
        </div>
    </section>
    <div class="mb-4 pb-lg-3"></div>
@endsection

@section('script')
@endsection

@section('style')
    <style>
        :root {
            --primary: #a61212; /* Deep slate blue for a modern, elegant tone */
            --secondary: #f5f6f5; /* Soft off-white for clean backgrounds */
            --text-dark: #5a0c0c; /* Dark gray for primary text */
            --text-muted: #560000; /* Muted gray for secondary text */
            --accent: #dfe6e9; /* Light gray for subtle highlights */
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, rgba(0, 0, 0, 0.6) 100%), url('https://via.placeholder.com/1920x600?text=EternaWatch+Hero');
            background-size: cover;
            background-position: center;
        }

        .hero-section h1, .hero-section p {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .about-section, .mission-vision-section, .core-values-section, .timeline-section, .commitment-section, .showroom-section {
            border-radius: 10px;
        }

        .image-wrapper {
            overflow: hidden;
            border-radius: 10px;
        }

        .image-wrapper img {
            transition: transform 0.4s ease;
        }

        .image-wrapper:hover img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.1));
            border-radius: 10px;
        }

        .value-card, .timeline-card, .showroom-card {
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-card:hover, .timeline-card:hover, .showroom-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-outline-light {
            border-width: 2px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-dark {
            color: var(--text-dark) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06) !important;
        }

        h1, h2, h3, h5 {
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.2px;
        }

        .lead {
            line-height: 1.8;
        }

        /* Layout fixes */
        .container {
            max-width: 1140px;
        }

        .hero-section {
            padding-top: 90px;
            padding-bottom: 90px;
        }

        .section-heading {
            position: relative;
            display: inline-block;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary);
        }
    </style>
@endsection