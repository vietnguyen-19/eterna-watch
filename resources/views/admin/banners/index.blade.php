@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0"><strong>Danh sách banner</strong></h5>
                                <div class="d-flex ms-auto">
                                    <a href="{{ route('admin.banners.trash') }}" class="btn btn-sm btn-warning mr-2">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                    </a>
                                    <a href="{{ route('admin.banners.create') }}" class="btn btn-sm btn-primary">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm banner
                                    </a>
                                </div>
                            </div>
                            
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-border-left alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Thành công!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-border-left alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Lỗi!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle" id="bannerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 20%">Hình ảnh</th>
                                            <th style="width: 30%">Tiêu đề</th>
                                            <th style="width: 15%">Vị trí</th>
                                            <th style="width: 10%">Trạng thái</th>
                                            <th style="width: 10%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($banners as $banner)
                                            <tr>
                                                <td class="align-middle">{{ $banner->id }}</td>
                                                <td style="width:18%;">
                                                    <div style="position: relative; width: 100%; padding-top: 56.25%; overflow: hidden; border-radius: 6px;">
                                                        @if ($banner->image)
                                                            <img src="{{ Storage::url($banner->image ?? 'avatar/default.jpeg') }}"
                                                                 alt="Banner"
                                                                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('theme/velzon/assets/images/no-img.jpg') }}"
                                                                 alt="No Image"
                                                                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                
                                                <td class="align-middle">{{ $banner->title ?? 'Không có tiêu đề' }}</td>
                                                <td class="align-middle ">
                                                    @switch($banner->position)
                                                        @case('home_start')
                                                            Trang chủ - Phần đầu
                                                            @break
                                                
                                                        @case('home_new_product')
                                                            Trang chủ - Sản phẩm mới
                                                            @break
                                                
                                                        @case('login')
                                                            Trang đăng nhập
                                                            @break
                                                
                                                        @case('register')
                                                            Trang đăng ký
                                                            @break
                                                
                                                        @case('shop')
                                                            Trang cửa hàng
                                                            @break
                                                
                                                        @case('blog')
                                                            Trang blog
                                                            @break
                                                
                                                        @case('forward_password')
                                                            Trang quên mật khẩu
                                                            @break
                                                
                                                        @default
                                                            Không rõ
                                                    @endswitch
                                                </td>
                                                
                                                <td class="align-middle">
                                                    @if ($banner->is_active == 1)
                                                        <span class="badge bg-success-subtle text-success">Hiển thị</span>
                                                    @elseif ($banner->is_active == 0)
                                                        <span class="badge bg-secondary-subtle text-secondary">Ẩn</span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning">Không xác
                                                            định</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning mr-1">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline"
                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có banner nào được tìm thấy.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
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
        .avatar-xs {
            height: 2.2rem;
            width: 2.2rem;
            object-fit: cover;
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

        .bg-primary-subtle {
            background-color: rgba(64, 81, 137, .1);
        }

        .bg-secondary-subtle {
            background-color: rgba(116, 120, 141, .1);
        }

        .bg-dark-subtle {
            background-color: rgba(33, 37, 41, .1);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bannerTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50],
                "order": [
                    [0, 'desc']
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Trang _PAGE_ / _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    }
                }
            });

            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection
