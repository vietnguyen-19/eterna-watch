@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Permission </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách Permission</a></li>
                <li class="breadcrumb-item active">Permission</li>
            </ol>
        </div>

    </div>
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">

                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Danh sách Permission </h5>
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
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>

                                    <th class="sort" data-sort="id">ID</th>    
                                    <th class="sort" data-sort="id">Name</th>                                    
                                    <th class="sort" data-sort="action">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($permissions as $permission)
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td><button class="btn btn-danger">Xóa </button></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="{{ asset('theme/velzon/https://cdn.lordicon.com/msoeawqm.json') }}"
                                    trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                    style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ customer We did not find any
                                    customer for you search.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" type="submit" name="deleteSelected"
                            class="btn btn-danger">
                            Xóa nhiều
                        </button>
                        <div class="pagination-wrap hstack gap-2" style="display: flex;">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0">
                                <li class="active"><a class="page" href="#" data-i="1" data-page="8">1</a>
                                </li>
                                <li><a class="page" href="#" data-i="2" data-page="8">2</a></li>
                            </ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
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
