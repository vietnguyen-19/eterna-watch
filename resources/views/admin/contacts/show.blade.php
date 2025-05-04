@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card h-100" id="customerList">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><b>Thông tin liên hệ</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div style="opacity: 0" class="d-flex flex-wrap align-items-center gap-2">
                                        <a href="{{ route('admin.contacts.destroy', $contact->id) }}" class="btn btn-danger">
                                            <i class="ri-delete-bin-line align-bottom me-1"></i> Xóa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <!-- Hiển thị thông tin liên hệ -->
                                <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                    <strong>Họ tên:</strong>
                                    <span>{{ $contact->name }}</span>
                                </div>
                                <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                    <strong>Email:</strong>
                                    <span>{{ $contact->email }}</span>
                                </div>
                                <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                    <strong>Ngày gửi:</strong>
                                    <span>{{ \Carbon\Carbon::parse($contact->sent_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <strong>Trạng thái:</strong>
                                    <span>
                                        @if ($contact->status === 'new')
                                            Chờ duyệt
                                        @elseif($contact->status === 'read')
                                            Đã xem
                                        @elseif($contact->status === 'done')
                                            Đã xử lý
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-9">
                    <div class="card h-100" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <!-- Cột tiêu đề -->
                                <div class="col-6">
                                    <h5 class="card-title mb-0"><strong>Nội dung liên hệ</strong></h5>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex align-items-center justify-content-end gap-3">
                                            <select name="status" id="status" class="form-control form-select w-auto"
                                                required>
                                                @php
                                                    $statuses = [
                                                        'new' => 'Chờ duyệt',
                                                        'read' => 'Đã xem',
                                                        'done' => 'Đã xử lý',
                                                    ];
                                                @endphp
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}"
                                                        {{ old('status', $contact->status) == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-info ml-2">Cập nhật trạng thái</button>
                                        </div>
                                        @error('status')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Nội dung:</strong>
                                <p>{{ $contact->message }}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.contacts.destroy', $contact->id) }}" class="btn btn-danger">
                                <i class="ri-delete-bin-line align-bottom me-1"></i> Xóa liên hệ
                            </a>
                            <a href="{{ route('admin.contacts.destroy', $contact->id) }}" class="btn btn-secondary">
                                <i class="ri-delete-bin-line align-bottom me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script-lib')
@endsection

@section('script')
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
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
            list-style-type: none;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-icon {
            position: absolute;
            left: -10px;
            width: 20px;
            height: 20px;
            background-color: #007bff;
            /* Màu xanh cho biểu tượng */
            border-radius: 50%;
            top: 0;
        }

        .timeline-content {
            padding-left: 40px;
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
@endsection
