@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                @if (session('thongbao'))
                    <div class="col-12">
                        <div id="thongbao-alert"
                            class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                            role="alert">
                            <i class="ri-notification-off-line label-icon"></i><strong>
                                {{ session('thongbao.message') }}</strong>

                        </div>
                    </div>
                @endif
                <div class="col-4">
                    <form action="{{ route('admin.attribute_values.store') }}" autocomplete="off" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0">Thêm mới giá trị thuộc tính
                                                <b>{{ $attribute->attribute_name }}</b>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="body row">

                                    <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                    <div class="mb-3 col-12">
                                        <label for="value_name" class="form-label">Gía trị thuộc tính</label>
                                        <input value="{{ old('value_name') }}" name="value_name" type="text"
                                            id="value_name" class="form-control" placeholder="Enter name">
                                        @error('value_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <input value="{{ old('note') }}" name="note" type="text" id="note"
                                            class="form-control" placeholder="Enter name">
                                        @error('note')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                    <button type="submit" class="btn btn-success" id="add-btn">Thêm giá trị </button>
                                    <a class="btn btn-secondary" href="{{ route('admin.attributes.index') }}"
                                        class="btn btn-light">Trở về</a>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Thuộc tính | <b>{{ $attribute->attribute_name }}</b>
                                        </h5>
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
                                        <table class="table table-bordered display" id="danhmucTable">
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="ten_danh_muc">Giá trị thuộc tính</th>
                                                    <th class="sort" data-sort="mo_ta">Ghi chú</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($attribute->attributeValues as $item)
                                                    <tr>

                                                        <td class="align-middle">{{ $item->id }}</td>
                                                        <td class="align-middle">{{ $item->value_name }}</td>
                                                        <td class="align-middle">
                                                            {{ $item->note ? $item->note : 'Trống' }}
                                                        </td>
                                                        <td class="align-middle">
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <!-- Edit Button -->
                                                                <li class="list-inline-item edit" title="Edit">
                                                                    <button
                                                                        class="btn btn-warning btn-icon waves-effect waves-light btn-sm open-edit-modal"
                                                                        data-id="{{ $item->id }}"
                                                                        data-value-name="{{ $item->value_name }}"
                                                                        data-note="{{ $item->note }}">
                                                                        <i class="nav-icon fa-solid fa-pen-nib"></i>
                                                                    </button>
                                                                </li>
                                                                <!-- Remove Button -->
                                                                <li class="list-inline-item" title="Remove">
                                                                    <form
                                                                        action="{{ route('admin.attribute_values.destroy', $item->id) }}"
                                                                        method="POST" style="display: inline-block;"
                                                                        onsubmit="return confirm('Bạn đã chắc chắn chưa?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-icon waves-effect waves-light btn-sm">
                                                                            <i class="nav-icon fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </li>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="ten_danh_muc">Giá thuộc tính</th>
                                                    <th class="sort" data-sort="mo_ta">Ghi chú</th>
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
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa giá trị thuộc tính</h5>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            @csrf
                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-3 col-12">
                                <label for="edit_value_name" class="form-label">Giá trị thuộc tính</label>
                                <input name="value_name" type="text" id="edit_value_name" class="form-control"
                                    placeholder="Nhập giá trị">
                                <div class="text-danger" id="error_value_name"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="edit_note" class="form-label">Ghi chú</label>
                                <input name="note" type="text" id="edit_note" class="form-control"
                                    placeholder="Nhập ghi chú">
                                <div class="text-danger" id="error_note"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#danhmucTable').DataTable({
            "paging": true, // Bật phân trang
            "lengthMenu": [10, 20, 50], // Số dòng hiển thị mỗi trang
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
    </script>
    <script>
        $(document).ready(function() {
            $(".open-edit-modal").click(function() {
                var id = $(this).data("id");
                var valueName = $(this).data("value-name");
                var note = $(this).data("note");

                // Đổ dữ liệu vào modal
                $("#edit_id").val(id);
                $("#edit_value_name").val(valueName);
                $("#edit_note").val(note);

                // Hiển thị modal
                $("#editModal").modal("show");
            });


            $("#editForm").submit(function(e) {
                e.preventDefault(); // Ngăn form reload

                var id = $("#edit_id").val();
                var valueName = $("#edit_value_name").val();
                var note = $("#edit_note").val();

                $.ajax({
                    url: "/admin/attribute_values/update/" + id, // URL xử lý cập nhật
                    type: "PUT", // Laravel yêu cầu PUT cho cập nhật
                    data: {
                        _token: $('input[name="_token"]').val(), // CSRF Token
                        value_name: valueName,
                        note: note,
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Cập nhật thành công!");
                            $("#editModal").modal("hide");
                            location.reload(); // Reload trang để cập nhật dữ liệu
                        } else {
                            alert("Có lỗi xảy ra, vui lòng thử lại.");
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $("#error_value_name").text(errors?.value_name ? errors.value_name[0] :
                            "");
                        $("#error_note").text(errors?.note ? errors.note[0] : "");
                    }
                });
            });
        });
    </script>
    <script>
        // Tự động đóng thông báo sau 5 giây (5000ms)
        setTimeout(function() {
            var alert = document.getElementById('thongbao-alert');
            if (alert) {
                // Sử dụng Bootstrap để đóng alert
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000); // 5000ms = 5 giây
    </script>
@endsection
