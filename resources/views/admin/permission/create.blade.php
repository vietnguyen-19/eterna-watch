@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Text Editors</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Text Editors</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
            <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                <h3 class="card-title">
                    Summernote
                </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <textarea id="summernote">
                Place <em>some</em> <u>text</u> <strong>here</strong>
                </textarea>
                </div>
                <div class="card-footer">
                Visit <a href="https://github.com/summernote/summernote/">Summernote</a> documentation for more examples
                and information about the plugin.
                </div>
            </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
        <div class="row">
            <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                <h3 class="card-title">
                    CodeMirror
                </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <textarea id="codeMirrorDemo" class="p-3">
                        <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Bookmarks</span>
                            <span class="info-box-number">41,410</span>
                            <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                            70% Increase in 30 Days
                            </span>
                        </div>
                        </div>
                </textarea>
                </div>
                <div class="card-footer">
                Visit <a href="https://codemirror.net/">CodeMirror</a> documentation for more examples and information
                about the plugin.
                </div>
            </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
        </section>
        <!-- /.content -->
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
