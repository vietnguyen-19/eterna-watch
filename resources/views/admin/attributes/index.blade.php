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
                                    <h5 class="card-title mb-0">Danh sách thuộc tính</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                        data-bs-target="#addAttributeModal">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm thuộc tính mới
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered display" id="attributeTable">
                                <thead class="text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên thuộc tính</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="attribute-list">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="align-middle">{{ $item->id }}</td>
                                            <td class="align-middle">{{ $item->attribute_name }}</td>
                                            <td class="align-middle">
                                                <a href="{{ route('admin.attribute_values.index', $item->id) }}"
                                                    class="btn btn-info btn-sm">Giá trị thuộc tính</a>
                                                <button class="btn btn-warning btn-sm edit-btn"
                                                    data-id="{{ $item->id }}"
                                                    data-name="{{ $item->attribute_name }}">Sửa</button>
                                                <button class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $item->id }}">Xóa</button>
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

    <div class="modal fade" id="addAttributeModal" tabindex="-1" aria-labelledby="addAttributeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttributeModalLabel">Thêm thuộc tính mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAttributeForm">
                        @csrf
                        <div class="mb-3">
                            <label for="attribute_name" class="form-label">Tên thuộc tính</label>
                            <input type="text" class="form-control" id="attribute_name" name="attribute_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAttributeModal" tabindex="-1" aria-labelledby="editAttributeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAttributeModalLabel">Chỉnh sửa thuộc tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAttributeForm">
                        @csrf
                        <input type="hidden" id="edit_attribute_id" name="id">
                        <div class="mb-3">
                            <label for="edit_attribute_name" class="form-label">Tên thuộc tính</label>
                            <input type="text" class="form-control" id="edit_attribute_name" name="attribute_name"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $('#attributeTable').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50],
            "searching": true,
            "ordering": true,
            "info": true,
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

            // Xóa thuộc tính
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');

                if (confirm('Bạn chắc chắn muốn xóa thuộc tính này?')) {
                    $.ajax({
                        url: "{{ route('admin.attributes.destroy', '') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#attribute-row-' + id).remove();
                                alert('Xóa thành công!');
                                location.reload();
                            } else {
                                alert('Xóa thất bại!');
                            }
                        },
                        error: function() {
                            alert('Đã xảy ra lỗi, vui lòng thử lại!');
                        }
                    });
                }
            });



            // Thêm thuộc tính bằng Ajax
            // Khởi tạo Notyf
            $('#addAttributeForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.attributes.store') }}",
                    type: "POST",
                    data: {
                        attribute_name: $('#attribute_name').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Ẩn modal và làm trống input
                            $('#addAttributeModal').modal('hide');
                            $('#attribute_name').val('');

                            // Thêm thuộc tính mới vào bảng
                            $('#attribute-list').append(`
                                <tr>
                                    <td>${response.data.id}</td>
                                    <td>${response.data.attribute_name}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">Giá trị thuộc tính</a>
                                        <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                </tr>
                            `);

                            // Hiển thị thông báo thành công
                            alert('Thuộc tính đã được thêm thành công!');
                            location.reload();
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            let errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                            alert(errorMessage); // Hiển thị lỗi chi tiết
                        } else {
                            alert('Đã xảy ra lỗi, vui lòng thử lại!');
                        }
                    }
                });
            });



            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#edit_attribute_id').val(id);
                $('#edit_attribute_name').val(name);
                $('#editAttributeModal').modal('show');
            });

            // Cập nhật thuộc tính bằng Ajax
            $('#editAttributeForm').on('submit', function(e) {
                e.preventDefault();
                let formData = {
                    id: $('#edit_attribute_id').val(),
                    attribute_name: $('#edit_attribute_name').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ route('admin.attributes.update') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editAttributeModal').modal('hide');
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi, vui lòng thử lại!');
                    }
                });
            });
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (Yêu cầu Popper.js) -->
    
@endsection
