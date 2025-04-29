@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><strong>Thùng rác danh mục</strong></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                                        <i class="ri-arrow-go-back-line me-1"></i>Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="categoryTable" class="table table-bordered align-middle text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 100px;">Hình ảnh</th>
                                        <th class="text-left">Tên danh mục</th>
                                        <th>Danh mục cha</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày xóa</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deletedParentCategories as $parent)
                                        @php
                                            $childCount = $parent->children->count();
                                            $rowspan = $childCount > 0 ? $childCount + 1 : 1;
                                        @endphp
                                        <tr>
                                            <td class="align-middle text-center" rowspan="{{ $rowspan }}">
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <img src="{{ Storage::url($parent->image ?? 'default-avatar.png') }}"
                                                        alt="Hình danh mục" class="rounded border"
                                                        style="width: 160px; height: 160px; object-fit: cover;">
                                                </div>
                                            </td>
                                            <td class="text-left text-info fw-bold">{{ $parent->name }}</td>
                                            <td>—</td>
                                            <td><span class="badge badge-danger">Đã xóa</span></td>
                                            <td>{{ $parent->deleted_at ? $parent->deleted_at->format('Y-m-d H:i') : '' }}
                                            </td>
                                            <td>
                                                {{-- Khôi phục --}}
                                                <form action="{{ route('admin.categories.restore', $parent->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có muốn khôi phục danh mục này không?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-sm btn-success" title="Khôi phục">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>

                                                {{-- Xóa vĩnh viễn --}}
                                                <form action="{{ route('admin.categories.force-delete', $parent->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa VĨNH VIỄN danh mục này không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Xóa vĩnh viễn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        @foreach ($parent->children as $child)
                                            <tr>
                                                <td class="text-left">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                                </td>
                                                <td>{{ $parent->name }}</td>
                                                <td><span class="badge badge-danger">Đã xóa</span></td>
                                                <td>{{ $child->deleted_at ? $child->deleted_at->format('Y-m-d H:i') : '' }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.categories.restore', $child->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Bạn có muốn khôi phục danh mục con này không?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-sm btn-success" title="Khôi phục">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.categories.force-delete', $child->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa VĨNH VIỄN danh mục con này không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" title="Xóa vĩnh viễn">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    {{-- Các danh mục con bị xóa mà không có cha đã xóa --}}
                                    @foreach ($deletedChildCategories as $child)
                                        <tr>
                                            <td></td>
                                            <td class="text-left">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                            </td>
                                            <td>{{ $child->parent->name ?? '—' }}</td>
                                            <td><span class="badge badge-danger">Đã xóa</span></td>
                                            <td>{{ $child->deleted_at ? $child->deleted_at->format('Y-m-d H:i') : '' }}
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.categories.restore', $child->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có muốn khôi phục danh mục con này không?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-sm btn-success" title="Khôi phục">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.categories.force-delete', $child->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa VĨNH VIỄN danh mục con này không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Xóa vĩnh viễn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
