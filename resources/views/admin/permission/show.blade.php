@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Permission </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Permission</a></li>
                <li class="breadcrumb-item active">Chi Tiết Permission</li>
            </ol>
        </div>

    </div>
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">

                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0"></h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-success add-btn"><i
                                    class="ri-add-line align-bottom me-1"></i>Thêm permission</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">


                <div>
                    @if (session('thongbao'))
                        <div id="thongbao-alert"
                            class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                            role="alert">
                            <i class="ri-notification-off-line label-icon"></i><strong>
                                {{ session('thongbao.message') }}</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>

                        </div>
                        @php
                            session()->forget('thongbao');
                        @endphp
                    @endif
                    <div class="table-responsive table-card mb-1 mt-2">
                        <table class="table align-middle" id="danhmucTable">
                            <thead class="table-light text-muted ">
                                <tr>
                                    <th class="sort" data-sort="id">ID : {{ $permission->id }}</th>
                                    <th class="sort" data-sort="name">Name : {{ $permission->name }}</th>
                                    <th>
                                        <a class="btn btn-info"
                                            href="{{ route('admin.permissions.index', $permission->id) }}">
                                            Quay lại
                                        </a>
                                    </th>
                                </tr>
                            </thead>

                        </table>

                    </div>

                </div>
            </div>

        </div>

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
