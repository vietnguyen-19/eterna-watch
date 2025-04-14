@extends('client.layouts.master')

@section('content')

<!-- Hero Section -->
<section class="vh-100 d-flex align-items-center text-white position-relative" style="background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4)), url('/images/hero-bg.jpg') center/cover no-repeat fixed;">
    <div class="container text-center z-1">
        <h1 class="display-2 fw-bold text-uppercase mb-3 animate__animated animate__fadeIn" style="letter-spacing: 4px;">{{ $about['title'] }}</h1>
        <p class="lead mx-auto fst-italic" style="max-width: 700px;">{{ $about['description'][0] }}</p>
    </div>
</section>

<!-- About Us Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                @if (!empty($about['image']))
                    <img src="{{ Storage::url($about['image'] ?? 'avatar/default.jpeg') }}" alt="About Image" class="img-fluid rounded-3 shadow-sm" style="object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                @endif
            </div>
            <div class="col-lg-6">
                @foreach (array_slice($about['description'], 1) as $p)
                    <p class="text-muted fs-5 lh-lg">{{ $p }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-white text-center">
    <div class="container">
        <h3 class="fw-bold text-uppercase mb-5" style="color: #e63946;">Sứ mệnh & Tầm nhìn</h3>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="p-4 bg-light rounded-3 shadow-sm h-100 transition-all" style="border-left: 4px solid #e63946;">
                    <h5 class="fw-bold mb-3" style="color: #e63946;">Sứ mệnh</h5>
                    <p class="text-muted">{{ $about['mission'] }}</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-4 bg-light rounded-3 shadow-sm h-100 transition-all" style="border-left: 4px solid #e63946;">
                    <h5 class="fw-bold mb-3" style="color: #e63946;">Tầm nhìn</h5>
                    <p class="text-muted">{{ $about['vision'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-5 bg-dark text-white">
    <div class="container text-center">
        <h3 class="fw-bold text-uppercase mb-5" style="color: #ffd60a;">Giá trị cốt lõi</h3>
        <div class="row g-4">
            @foreach ([
                ['icon' => 'bi-lightbulb-fill', 'title' => 'Sáng tạo', 'desc' => 'Đổi mới trong thiết kế và dịch vụ để tạo sự khác biệt.'],
                ['icon' => 'bi-shield-lock-fill', 'title' => 'Uy tín', 'desc' => 'Xây dựng niềm tin bền vững với khách hàng.'],
                ['icon' => 'bi-people-fill', 'title' => 'Khách hàng là trung tâm', 'desc' => 'Hướng tới sự hài lòng và trải nghiệm tối ưu.']
            ] as $value)
                <div class="col-md-4">
                    <div class="p-4 bg-dark-subtle rounded-3 shadow-lg h-100 transition-all" style="background: #1a1a1a;">
                        <i class="bi {{ $value['icon'] }} fs-2 mb-3" style="color: #ffd60a;"></i>
                        <h5 class="fw-bold">{{ $value['title'] }}</h5>
                        <p class="text-light opacity-75">{{ $value['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h3 class="fw-bold text-uppercase mb-5" style="color: #e63946;">Hành trình phát triển</h3>
        <div class="position-relative">
            <div class="timeline-line position-absolute top-0 start-50 translate-middle-x bg-secondary" style="width: 2px; height: 100%;"></div>
            @foreach ([
                ['year' => '2018', 'desc' => 'Khởi nghiệp với ước mơ kiến tạo không gian sống nghệ thuật.', 'side' => 'left'],
                ['year' => '2020', 'desc' => 'Mở showroom đầu tiên tại TP. Hồ Chí Minh.', 'side' => 'right'],
                ['year' => '2022', 'desc' => 'Ra mắt hệ thống bán hàng online toàn quốc.', 'side' => 'left'],
                ['year' => '2024', 'desc' => 'Hợp tác với các nhà thiết kế nội thất nổi tiếng.', 'side' => 'right']
            ] as $item)
                <div class="row mb-4 timeline-item {{ $item['side'] }}">
                    <div class="col-md-5 {{ $item['side'] === 'left' ? 'offset-md-1 text-md-end' : 'offset-md-6 text-md-start' }}">
                        <div class="p-3 bg-white rounded-3 shadow-sm position-relative">
                            <h5 class="fw-bold" style="color: #e63946;">{{ $item['year'] }}</h5>
                            <p class="text-muted">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Commitment -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container">
        <div class="p-5 bg-dark-subtle rounded-3 shadow-lg" style="border-left: 5px solid #ffd60a;">
            <h3 class="fw-bold mb-4 text-uppercase" style="color: #ffd60a;">Cam kết của chúng tôi</h3>
            <p class="fs-5 lh-lg opacity-75">“Mang đến sản phẩm nội thất chất lượng cao, dịch vụ tận tâm – biến mỗi căn nhà thành tổ ấm đích thực.”</p>
        </div>
    </div>
</section>

<!-- Showrooms -->
<section class="py-5 bg-white">
    <div class="container">
        <h3 class="fw-bold text-uppercase text-center mb-5" style="color: #e63946;">Hệ thống showroom</h3>
        <div class="row g-4">
            @foreach ([
                ['city' => 'TP. Hồ Chí Minh', 'address' => '123 Lý Tự Trọng, Quận 1'],
                ['city' => 'Hà Nội', 'address' => '456 Trần Duy Hưng, Cầu Giấy'],
                ['city' => 'Đà Nẵng', 'address' => '789 Nguyễn Văn Linh']
            ] as $showroom)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 transition-all hover-shadow">
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #e63946;">{{ $showroom['city'] }}</h5>
                            <p class="card-text text-muted">{{ $showroom['address'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

<style>
.transition-all { transition: all 0.3s ease; }
.hover-shadow:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.15); transform: translateY(-5px); }
.timeline-item.left .bg-white::after { content: ''; position: absolute; top: 50%; right: -10px; width: 10px; height: 10px; background: #e63946; border-radius: 50%; transform: translateY(-50%); }
.timeline-item.right .bg-white::after { content: ''; position: absolute; top: 50%; left: -10px; width: 10px; height: 10px; background: #e63946; border-radius: 50%; transform: translateY(-50%); }
</style>