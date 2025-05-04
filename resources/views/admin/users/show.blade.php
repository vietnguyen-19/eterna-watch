@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Chi tiết tài khoản</h5>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                                        <i class="ri-arrow-left-line align-middle"></i> Quay lại
                                    </a>

                                    <a href="{{ route('admin.users.toggle-status', $user->id) }}"
                                        class="btn btn-sm btn-{{ $user->status === 'active' ? 'warning' : 'success' }}">
                                        {{ $user->status === 'active' ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                                    </a>
                                    @if (Auth::check() && Auth::id() === $user->id)
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-pencil-line align-middle"></i> Chỉnh sửa
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <div class="row d-flex align-items-stretch">
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="position-relative d-inline-block mb-3">
                                                <div
                                                    class="avatar-xl rounded-circle overflow-hidden border border-3 border-primary shadow">
                                                    @if ($user->avatar)
                                                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                                            class="rounded-circle avatar-xl">
                                                    @else
                                                        <img src="{{ Storage::url('avatar/default.jpeg') }}"
                                                            alt="Avatar" class="rounded-circle avatar-xl">
                                                    @endif

                                                </div>
                                            </div>
                                            <h5 class="mb-1 mt-2">{{ $user->name }}</h5>
                                            <p class="text-muted mb-2">{{ $user->email }}</p>
                                            @if ($user->role)
                                                <span class="badge bg-gradient-primary px-3 py-2 rounded-pill">
                                                    @switch($user->role->name)
                                                        @case('admin')
                                                            Quản trị viên
                                                        @break

                                                        @case('staff')
                                                            Nhân viên
                                                        @break

                                                        @case('customer')
                                                            Khách hàng
                                                        @break

                                                        @default
                                                            {{ ucfirst($user->role->name) }}
                                                    @endswitch
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Chưa có vai
                                                    trò</span>
                                            @endif
                                        </div>
                                        <div class="card-body pt-0">
                                            <ul class="list-group list-group-flush text-start">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <strong>Số điện thoại:</strong>
                                                    <span
                                                        class="float-end text-muted">{{ $user->phone ?? 'Chưa có' }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <strong>Trạng thái:</strong>
                                                    <span class="float-end">
                                                        @switch($user->status)
                                                            @case('active')
                                                                <span class="badge bg-success-subtle text-success">Hoạt động</span>
                                                            @break

                                                            @case('inactive')
                                                                <span class="badge bg-danger-subtle text-danger">Đã khóa</span>
                                                            @break

                                                            @default
                                                                <span class="badge bg-secondary-subtle text-secondary">Không xác
                                                                    định</span>
                                                        @endswitch
                                                    </span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <strong>Ngày tạo:</strong>
                                                    <span
                                                        class="float-end text-muted">{{ $user->created_at->format('d/m/Y H:i:s') }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <strong>Cập nhật lần cuối:</strong>
                                                    <span
                                                        class="float-end text-muted">{{ $user->updated_at->format('d/m/Y H:i:s') }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-header d-flex align-items-center">
                                            <h5 class="card-title mb-0 text-primary"><strong>Thông tin địa chỉ</strong></h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($address)
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Họ tên:</strong>
                                                        <span class="text-muted">{{ $address->full_name }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Số điện thoại:</strong>
                                                        <span class="text-muted">{{ $address->phone_number }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Email:</strong>
                                                        <span class="text-muted">{{ $address->email }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Địa chỉ chi tiết:</strong>
                                                        <span class="text-muted">{{ $address->street_address }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Phường/Xã:</strong>
                                                        <span class="text-muted">{{ $address->ward }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Quận/Huyện:</strong>
                                                        <span class="text-muted">{{ $address->district }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Tỉnh/Thành phố:</strong>
                                                        <span class="text-muted">{{ $address->city }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <strong>Quốc gia:</strong>
                                                        <span class="text-muted">{{ $address->country }}</span>
                                                    </li>
                                                </ul>
                                            @else
                                                <div class="text-center text-muted">
                                                    <i class="bi bi-exclamation-circle fs-1 d-block mb-2"></i>
                                                    <p class="mb-0">Chưa có thông tin địa chỉ</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <style>
        .avatar-xl {
            height: 7.5rem;
            width: 7.5rem;
        }

        .bg-primary-subtle {
            background-color: rgba(64, 81, 137, .1);
        }

        .bg-success-subtle {
            background-color: rgba(10, 179, 156, .1);
        }

        .bg-danger-subtle {
            background-color: rgba(240, 101, 72, .1);
        }

        .bg-warning-subtle {
            background-color: rgba(247, 184, 75, .1);
        }

        .bg-secondary-subtle {
            background-color: rgba(116, 120, 141, .1);
        }

        .bg-dark-subtle {
            background-color: rgba(33, 37, 41, .1);
        }
    </style>
@endsection

@section('script')
    <script>
        // Kích hoạt tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
