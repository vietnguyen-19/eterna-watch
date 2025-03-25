@extends('client.layouts.master')

@section('content')
<!-- Hero Section -->
<section class="text-white text-center position-relative" style="background: linear-gradient(135deg, #d90429, #a0001e);padding: 250px 0px 25px 0">
    <div class="container">
        <!-- Hiệu ứng nền mờ -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" 
             style="background-image: url('/path-to-your-background.jpg'); background-size: cover; background-position: center;">
        </div>

        <!-- Nội dung -->
        <div class="position-relative">
            <h2 style="font-size: 2.5rem" class="display-4 fw-bold text-uppercase animate-fade-in">{{ $about['title'] }}</h2>
            <p class="lead animate-fade-in delay-1">{{ $about['description'][0] }}</p>
        </div>
    </div>
</section>

<!-- About Description -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                @foreach (array_slice($about['description'], 1) as $paragraph)
                    <p class="text-muted">{{ $paragraph }}</p>
                @endforeach
            </div>
            <div class="col-lg-6 text-center">
                @if (!empty($about['image']))
                    <img src="{{ Storage::url($about['image'] ?? 'avatar/default.jpeg') }}" alt="EternaWatch" class="img-fluid rounded shadow">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section style="background: #252627" class="py-5">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6">
                <div class="p-4 rounded shadow-sm bg-white">
                    <i class="fa-solid fa-bullseye fa-3x mb-3"></i>
                    <h3 class="fw-bold">Sứ Mệnh</h3>
                    <p class="text-muted">{{ $about['mission'] }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded shadow-sm bg-white">
                    <i class="fa-solid fa-eye fa-3x mb-3"></i>
                    <h3  class="fw-bold">Tầm Nhìn</h3>
                    <p class="text-muted">{{ $about['vision'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<<section class="py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">Giá Trị Cốt Lõi</h3>
        <div class="row">
            @foreach ($about['values'] as $index => $value)
                <div class="col-md-6 d-flex mb-4">
                    <div class="d-flex align-items-center bg-dark text-white p-4 shadow-sm rounded w-100 h-100">
                        <!-- Số thứ tự hình tròn, căn giữa -->
                        <div class="d-flex align-items-center justify-content-center text-white fw-bold rounded-circle flex-shrink-0"
                             style="width: 50px; height: 50px; font-size: 1.5rem; line-height: 50px;background-color: #d90429">
                            {{ $index + 1 }}
                        </div>
                        <!-- Nội dung -->
                        <p class="mb-0 ms-3 flex-grow-1">{{ $value }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- History Timeline -->
<section  style="background: #252627" class="py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Hành Trình Phát Triển</h3>
        <div class="timeline">
            @foreach ($about['history'] as $event)
                <div class="timeline-item d-flex">
                    <p class="text-white">{{ $event }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Commitment -->
<section class="py-5">
    <div class="container text-center">
        <h3 class="fw-bold  mb-4">{{ $about['commitment'][0] }}</h3>
        <div class="row justify-content-center">
            @foreach (array_slice($about['commitment'], 1) as $item)
                <div class="col-md-9 col-lg-9 mb-3">
                    <div style="background: #4b88a2; border-radius: 5px" class="p-3 shadow-sm">
                        <p class="text-white text-center mb-0">{{ $item }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-5 text-muted ">
    <div class="container text-center col-md-9 col-lg-8">
        @foreach ($about['customer_experience'] as $exp)
            <blockquote style="background: #252627; border-left: 5px solid #d90429; border-radius: 5px" class="blockquote"><i>{{ $exp }}</i></blockquote>
        @endforeach
    </div>
</section>
<!-- Showrooms -->
<section style="background: #252627" class="py-5 ">
    <div class="container text-center">
        <h3 class="fw-bold  ">Hệ Thống Showroom</h3>
        <p class="text-muted">{{ $about['showrooms'][0] }}</p>
        <div class="row justify-content-center">
            @foreach (array_slice($about['showrooms'], 1) as $showroom)
                <div class="col-md-4 mb-3">
                    <div style="border-radius: 5px" class="d-flex align-items-center p-3 shadow-sm bg-white">
                        <i class="fa-solid fa-map-marker-alt fa-2x text-primary me-3"></i>
                        <p class="mb-0 text-muted">{{ $showroom }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Customer Experience -->

@endsection

@section('style')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        
    }
    h3{
        color: #d90429;
    }
    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 20px;
        border-left: 4px solid #3a86ff;
    }

    .timeline-item {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .timeline .icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
