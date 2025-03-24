@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <div class="user-info mb-3"
                        style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f8f9fa; border-radius: 5px 5px 0 0; width: 100%; box-sizing: border-box;">
                        <div class="avatar" style="width: 88px; height: 88px; margin-right: 15px;">
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="user-details">
                            <strong>{{ auth()->user()->name }}</strong> <br>
                            <small>{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                    <nav class="nav flex-column account-sidebar sticky-sidebar">

                        <a href="{{ route('account.order') }}" class="nav-link">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng
                        </a>
                        <a href="{{ route('account.re_password') }}" class="nav-link active">
                            <i class="fas fa-key me-2"></i> Cập nhật mật khẩu
                        </a>
                        <a href="{{ route('account.edit') }}" class="nav-link ">
                            <i class="fas fa-user me-2"></i> Chi tiết tài khoản
                        </a>
                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link text-danger logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </nav>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success" id="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif


                        <form name="password_update_form" class="needs-validation" novalidate method="POST"
                        action="{{ route('account.update_pass') }}">
                      @csrf
                  
                      <div class="row">
                          <div class="col-md-12">
                              <div class="card shadow-sm">
                                  <div class="card-body">
                                      <h5 class="fw-bold text-primary pb-3">Cập nhật mật khẩu</h5>
                  
                                      <!-- Mật khẩu hiện tại -->
                                      <div class="form-floating my-3">
                                          <input type="password" class="form-control" id="current_password"
                                                 name="current_password" placeholder="Mật khẩu hiện tại" required>
                                          <label for="current_password"><strong>Mật khẩu hiện tại</strong></label>
                                      </div>
                  
                                      <!-- Mật khẩu mới -->
                                      <div class="form-floating my-3">
                                          <input type="password" class="form-control" id="new_password"
                                                 name="new_password" placeholder="Mật khẩu mới" required>
                                          <label for="new_password"><strong>Mật khẩu mới</strong></label>
                                      </div>
                  
                                      <!-- Xác nhận mật khẩu mới (Cập nhật tên thành 'new_password_confirmation') -->
                                      <div class="form-floating my-3">
                                          <input type="password" class="form-control" id="new_password_confirmation"
                                                 name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                                          <label for="new_password_confirmation"><strong>Nhập lại mật khẩu mới</strong></label>
                                      </div>
                  
                                      <!-- Nút cập nhật -->
                                      <div class="col-md-12 text-center mt-4">
                                          <button class="btn btn-primary">Lưu thay đổi</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
                    </div>
                </div>
        </section>
    </main>


    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>
        // Set timeout to hide the success message after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const avatarInput = document.getElementById("avatar");
            const avatarHidden = document.getElementById("avatar-hidden");

            const pond = FilePond.create(avatarInput, {
                allowMultiple: false,
                allowImagePreview: true,
                imagePreviewHeight: 200,
                labelIdle: "Kéo & thả ảnh hoặc <span class='filepond--label-action'>chọn ảnh</span>",
                server: {
                    process: {
                        url: "{{ url('/account/upload-image') }}",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        onload: (response) => {
                            try {
                                let res = JSON.parse(response);
                                if (res.success) {
                                    avatarHidden.value = res.path;
                                } else {
                                    alert("Lỗi: " + (res.message || "Không thể tải ảnh lên."));
                                }
                            } catch (error) {
                                console.error("Lỗi JSON:", error);
                                alert("Lỗi không xác định khi tải ảnh lên.");
                            }
                        }
                    },
                    revert: (filename, load) => {
                        fetch("{{ url('/account/remove-image') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    path: avatarHidden.value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    avatarHidden.value = "";
                                } else {
                                    alert("Lỗi: " + (data.message || "Không thể xóa ảnh."));
                                }
                                load();
                            })
                            .catch(error => {
                                console.error("Lỗi khi xóa ảnh:", error);
                                alert("Lỗi kết nối đến server.");
                                load();
                            });
                    }
                }
            });

            // ✅ Thêm ảnh cũ vào FilePond sau khi khởi tạo
            let oldImage = "{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}";
            if (oldImage) {
                fetch(oldImage)
                    .then(res => {
                        if (res.ok) {
                            pond.addFile(oldImage, {
                                source: oldImage
                            });
                        } else {
                            console.error("Ảnh không tồn tại hoặc không thể tải.");
                        }
                    })
                    .catch(error => console.error("Lỗi khi tải ảnh:", error));
            }
        });
    </script>
@endsection
@section('style')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        /* Sidebar */
        .account-sidebar .nav-link {
            font-size: 16px;
            padding: 12px 18px;
            border-radius: 3px;
            background: #fdfdfd;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            color: #333;
            font-weight: 500;
        }

        .account-sidebar .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .account-sidebar .nav-link:hover {
            background: #ececec;
            padding-left: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar .nav-link.active {
            background: #e84040;
            color: #ffffff;
            font-weight: bold;
        }

        /* Hiệu ứng hover cho liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Nội dung chính */
        .content-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 18px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #d3401f !important;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #fff5f5;
            padding-left: 22px;
        }

        /* Responsive tối ưu */
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }

            .nav {
                border-bottom: 1px solid #ddd;
            }

            .content-box {
                margin-top: 20px;
            }
        }
    </style>
@endsection
