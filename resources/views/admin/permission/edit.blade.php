@extends('admin.layouts.master')
@section('content')
    <div class="w-60">
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Cập nhập danh sách </h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Name: </label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $permission->name }} ">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3"> </div>
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Cập
                                            nhập</button>
                                        <th>
                                            <a class="btn btn-info" href="{{ route('admin.permissions.index') }}"> Quay
                                                lại</a>
                                        </th>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script-lib')
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <!-- Sweet Alerts js -->


    <!-- Sweet alert init js-->
    <script src="{{ asset('theme/velzon/assets/js/pages/sweetalerts.init.js') }}"></script>

    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
@section('script')
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
    <script>
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;

            // Tạo một form giả lập để gửi yêu cầu DELETE
            var deleteForm = document.createElement('form');
            deleteForm.action = form.action;
            deleteForm.method = 'POST';

            // Thêm token CSRF
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            deleteForm.appendChild(csrfToken);

            // Thêm trường để giả lập DELETE
            var deleteMethod = document.createElement('input');
            deleteMethod.type = 'hidden';
            deleteMethod.name = '_method';
            deleteMethod.value = 'DELETE';
            deleteForm.appendChild(deleteMethod);

            // Thêm các checkbox được chọn vào form mới
            var checkboxes = form.querySelectorAll('input[name="ids[]"]:checked');
            checkboxes.forEach(function(checkbox) {
                var hiddenCheckbox = document.createElement('input');
                hiddenCheckbox.type = 'hidden';
                hiddenCheckbox.name = 'ids[]';
                hiddenCheckbox.value = checkbox.value;
                deleteForm.appendChild(hiddenCheckbox);
            });

            document.body.appendChild(deleteForm);
            deleteForm.submit();
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection
