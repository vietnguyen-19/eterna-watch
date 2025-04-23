@extends('client.account.main')
@section('account_content')
    <div class="row">
        <!-- Card Thông tin tài khoản -->
        <div class="col-md-12">
            <form name="account_edit_form" class="needs-validation" novalidate="" method="POST"
                action="{{ route('account.update') }}">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center" style="min-height: 60px;">
                        <h5 class="fw-bold text-primary m-0">Thông tin tài khoản</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-9">

                                <!-- Họ tên -->
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="account_name" name="name"
                                        value="{{ Auth::user()->name }}" placeholder="Họ và tên" required="">
                                    <label for="account_name"><strong>Họ và tên</strong></label>
                                </div>

                                <!-- Email -->
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" id="account_email" name="email"
                                        value="{{ Auth::user()->email }}" placeholder="Email" required="">
                                    <label for="account_email"><strong>Email</strong></label>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="account_phone" name="phone"
                                        value="{{ Auth::user()->phone }}" placeholder="Số điện thoại" required="">
                                    <label for="account_phone"><strong>Số điện thoại</strong></label>
                                </div>

                                <!-- Giới tính -->
                                <div class="form-floating my-3">
                                    <select class="form-select form-control" id="gender" name="gender">
                                        <option value="1" {{ Auth::user()->gender == 1 ? 'selected' : '' }}>
                                            Nam</option>
                                        <option value="0" {{ Auth::user()->gender == 0 ? 'selected' : '' }}>Nữ
                                        </option>
                                    </select>
                                    <label for="gender"><strong>Giới tính</strong></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12 text-center">
                                    <input type="file" id="avatar" name="avatar" class="filepond">
                                    <input type="hidden" id="avatar-hidden" name="avatar_hidden"
                                        value="{{ Auth::user()->avatar ?? '' }}">
                                </div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror


                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex align-items-center" style="min-height: 60px;">
                        <button class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>


        <!-- Card Địa chỉ -->
        <div class="col-md-12 mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between"
                    style="min-height: 60px;">
                    <h5 class="fw-bold text-primary m-0">Địa chỉ</h5>
                    <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-info add-btn">
                        <i class="ri-add-line align-bottom me-1"></i>Thêm địa chỉ
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            style="width: 100%; border-collapse: collapse; font-family: 'Arial', sans-serif; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden;">
                            <thead style="background-color: #f3f4f6; color: #1a1a1a; font-weight: 600; text-align: center;">
                                <tr>
                                    <th
                                        style="width: 5%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        STT</th>
                                    <th
                                        style="width: 15%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Họ tên</th>
                                    <th
                                        style="width: 12%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Số điện thoại</th>
                                    <th
                                        style="width: 18%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Email</th>
                                    <th
                                        style="width: 20%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Địa chỉ</th>
                                    <th
                                        style="width: 12%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Mặc định</th>
                                    <th
                                        style="width: 18%; font-weight:bold; padding: 16px; font-size: 0.8rem; border-bottom: 1px solid #e5e7eb;">
                                        Thao tác</th>
                                </tr>

                            </thead>
                            <tbody style="text-align: center;">
                                @foreach (Auth::user()->addresses as $index => $address)
                                    <tr
                                        style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#fafafa' }}; transition: background-color 0.2s;">
                                        <td
                                            style="padding: 16px; font-size: 0.8rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            {{ $index + 1 }}</td>
                                        <td
                                            style="padding: 16px; font-size: 0.8rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            {{ $address->full_name }}</td>
                                        <td
                                            style="padding: 16px; font-size: 0.8rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            {{ $address->phone_number }}</td>
                                        <td
                                            style="padding: 16px; font-size: 0.8rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            {{ $address->email }}</td>
                                        <td
                                            style="padding: 16px; font-size: 0.8rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            {{ $address->street_address }},
                                            {{ $address->ward }},
                                            {{ $address->district }},
                                            {{ $address->city }},
                                            {{ $address->country }}
                                        </td>
                                        <td
                                            style="padding: 16px; font-size: 0.95rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">
                                            @if ($address->is_default)
                                                <span title="Địa chỉ mặc định"
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: #fef3c7;">
                                                    <i class="fas fa-star" style="font-size: 1rem; color: #f59e0b;"></i>
                                                </span>
                                            @else
                                                <form action="{{ route('addresses.setDefault', $address->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn đặt địa chỉ này làm mặc định?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" title="Đặt làm mặc định"
                                                        style="background-color: #e5e7eb; color: #9ca3af; padding: 8px; border-radius: 50%; border: none; cursor: pointer; transition: background-color 0.2s, color 0.2s; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-star" style="font-size: 1rem;"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td
                                            style="padding: 16px; font-size: 0.95rem; color: #4a4a4a; border-bottom: 1px solid #e5e7eb;">


                                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Xóa địa chỉ"
                                                    style="background-color: #fee2e2; color: #991b1b; padding: 8px; border-radius: 8px; border: none; cursor: pointer; transition: background-color 0.2s; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-trash" style="font-size: 1rem;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (Auth::user()->addresses->isEmpty())
                                    <tr>
                                        <td colspan="7"
                                            style="padding: 24px; font-size: 1rem; color: #6b7280; text-align: center; background-color: #ffffff;">
                                            Bạn chưa thêm địa chỉ nào.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

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
                title: 'Lỗi!',
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
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
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
