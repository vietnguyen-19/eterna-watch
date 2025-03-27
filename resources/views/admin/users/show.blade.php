@extends('admin.layouts.master')

@section('content')
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
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="ri-pencil-line align-middle"></i> Chỉnh sửa
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($user->avatar && Storage::exists('public/' . $user->avatar))
                                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                        class="rounded-circle avatar-xl">
                                @else
                                    <img src="{{ asset('theme/velzon/assets/images/users/avatar-1.jpg') }}"
                                        alt="Avatar" class="rounded-circle avatar-xl">
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" scope="row">Họ tên :</th>
                                            <td class="text-muted">{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Email :</th>
                                            <td class="text-muted">{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Số điện thoại :</th>
                                            <td class="text-muted">{{ $user->phone ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Vai trò :</th>
                                            <td>
                                                @if($user->role)
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $user->role->name == 'employee' ? 'Nhân viên' : ($user->role->name == 'user' ? 'Khách hàng' : $user->role->name) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">Chưa có</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Trạng thái :</th>
                                            <td>
                                                @switch($user->status)
                                                    @case('active')
                                                        <span class="badge bg-success-subtle text-success">Hoạt động</span>
                                                        @break
                                                    @case('inactive')
                                                        <span class="badge bg-danger-subtle text-danger">Ngưng hoạt động</span>
                                                        @break
                                                    @case('banned')
                                                        <span class="badge bg-dark-subtle text-dark">Đã khóa</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning-subtle text-warning">Chờ duyệt</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary-subtle text-secondary">Không xác định</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Ngày tạo :</th>
                                            <td class="text-muted">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Cập nhật lần cuối :</th>
                                            <td class="text-muted">{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Địa chỉ</h5>
                                </div>
                                <div class="card-body">
                                    @if($address)
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Họ tên :</th>
                                                        <td class="text-muted">{{ $address->full_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Số điện thoại :</th>
                                                        <td class="text-muted">{{ $address->phone_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Email :</th>
                                                        <td class="text-muted">{{ $address->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Địa chỉ chi tiết :</th>
                                                        <td class="text-muted">{{ $address->street_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Phường/Xã :</th>
                                                        <td class="text-muted">{{ $address->ward }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Quận/Huyện :</th>
                                                        <td class="text-muted">{{ $address->district }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Tỉnh/Thành phố :</th>
                                                        <td class="text-muted">{{ $address->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Quốc gia :</th>
                                                        <td class="text-muted">{{ $address->country }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <p>Chưa có thông tin địa chỉ</p>
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
@endsection

@section('style')
<style>
    .avatar-xl {
        height: 7.5rem;
        width: 7.5rem;
    }
    .bg-primary-subtle { background-color: rgba(64, 81, 137, .1); }
    .bg-success-subtle { background-color: rgba(10, 179, 156, .1); }
    .bg-danger-subtle { background-color: rgba(240, 101, 72, .1); }
    .bg-warning-subtle { background-color: rgba(247, 184, 75, .1); }
    .bg-secondary-subtle { background-color: rgba(116, 120, 141, .1); }
    .bg-dark-subtle { background-color: rgba(33, 37, 41, .1); }
</style>
@endsection

@section('script')
<script>
    // Kích hoạt tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection 