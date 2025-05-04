@extends('admin.layouts.master')
@section('content')

    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('thongbao'))
                                    <div id="thongbao-alert"
                                        class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                                        role="alert">
                                        <i class="ri-notification-off-line label-icon"></i><strong>
                                            {{ session('thongbao.message') }}</strong>

                                    </div>
                                    @php
                                        session()->forget('thongbao');
                                    @endphp
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách cài đặt</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.settings.create') }}" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm cài đặt</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered" aria-describedby="example2_info"
                                            id="danhmucTable">
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="key">Tên cài đặt</th>
                                                    <th class="sort" data-sort="value">Nội dung</th>
                                                    <th class="sort" data-sort="value">Kiểu dữ liệu</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">

                                                @foreach ($setting as $item)
                                                    <tr>
                                                        <td class="id">{{ $item->id }}</td>
                                                        <td class="key">{{ $item->key }}</td>
                                                        <td class="value">{{ $item->value }}</td>
                                                        <td class="value">{{ $item->type }}</td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <!-- Edit Button -->
                                                                <li class="list-inline-item edit" title="Edit">
                                                                    <a href="{{ route('admin.settings.edit', $item->id) }}"
                                                                        class="btn btn-warning btn-icon waves-effect waves-light btn-sm">
                                                                        Sửa
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="key">Tên cài đặt</th>
                                                    <th class="sort" data-sort="value">Nội dung</th>
                                                    <th class="sort" data-sort="value">Kiểu dữ liệu</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- Breadcrumb --}}
<!-- <nav aria-label="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a href="/" itemprop="item"><span itemprop="name">Trang chủ</span></a>
      <meta itemprop="position" content="1" />
    </li>
    <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <span itemprop="name">Dịch vụ</span>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</nav> -->

{{-- Danh sách dịch vụ --}}
<!-- <div itemscope itemtype="https://schema.org/ItemList">
  <meta itemprop="name" content="Danh sách dịch vụ" />
  <meta itemprop="itemListOrder" content="http://schema.org/ItemListOrderAscending" />
  <meta itemprop="numberOfItems" content="{{ count($services) }}" />

  @foreach ($services as $index => $service)
    <article itemprop="itemListElement" itemscope itemtype="https://schema.org/Service">
      <meta itemprop="position" content="{{ $index + 1 }}" />

      <h2 itemprop="name">{{ $service->name }}</h2>
      <p itemprop="description">{{ $service->description }}</p>

      @if ($service->image)
        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
      @endif -->

      {{-- Action buttons (edit/delete) --}}
      <!-- <div>
        <a href="{{ route('services.edit', $service->id) }}">Chỉnh sửa</a>
        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit">Xoá</button>
        </form>
      </div>
    </article>
  @endforeach
</div> -->

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#danhmucTable').DataTable({
                "paging": true, // Bật phân trang
                "lengthMenu": [5, 20, 50], // Số dòng hiển thị mỗi trang
                "searching": true, // Bật ô tìm kiếm
                "ordering": true, // Bật sắp xếp cột
                "info": true, // Hiển thị thông tin tổng số dòng
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Đang hiển thị  _START_  đến  _END_  của  _TOTAL_  mục",
                    "infoEmpty": "Không có dữ liệu",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Trang đầu",
                        "last": "Trang cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    }
                }
            });
        });
    </script>

    <script>
        // Tự động đóng thông báo sau 5 giây (5000ms)
        setTimeout(function () {
            var alert = document.getElementById('thongbao-alert');
            if (alert) {
                // Sử dụng Bootstrap để đóng alert
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000); // 5000ms = 5 giây
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection