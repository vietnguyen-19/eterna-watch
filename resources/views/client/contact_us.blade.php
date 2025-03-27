@extends('client.layouts.master')

@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-3"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                <div class="contact-container shadow-lg mt-2">
                    <div class="form-wrapper">
                        <div class="form-header">
                            <h4 class="fw-bold text-dark"><i class="fas fa-envelope me-2"></i>Liên Hệ Với Chúng Tôi</h4>
                        </div>
                        <form action="{{ route('client.contact_us.store') }}" method="POST">
                            @csrf
                            <!-- Trường Name -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên của bạn" value="{{ old('name') }}">
                                <label for="name">Họ và tên</label>
                                @error('name')
                                    <span style="color: #bd1c1c">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Trường Email -->
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email của bạn" value="{{ old('email') }}">
                                <label for="email">Địa chỉ Email</label>
                                @error('email')
                                    <span style="color: #bd1c1c">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Trường Message -->
                            <div class="form-floating mb-4">
                                <textarea class="form-control" id="message" name="message" placeholder="Nội dung tin nhắn" style="height: 150px">{{ old('message') }}</textarea>
                                <label for="message">Tin nhắn của bạn</label>
                                @error('message')
                                    <span style="color: #bd1c1c">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nút gửi -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-submit text-white">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 pb-xl-5"></div>
@endsection

@section('script')
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
@endsection

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .contact-container {
            background: url('https://images.unsplash.com/photo-1517248135467-2c7ed3ab7221?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            border-radius: 5px;
            overflow: hidden;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
        }

        .form-header {
            border-bottom: 3px solid #bd1c1c;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-control,
        .form-control:focus {
            border: none;
            border: 2px solid #ddd;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-bottom-color: #bd1c1c;
        }

        .btn-submit {
            background: #bd1c1c;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .btn-submit:hover {
            background: #cf1818;
            transform: translateY(-2px);
        }

        .form-floating label {
            color: #666;
            font-weight: 500;
        }

        .text-danger {
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>
@endsection
