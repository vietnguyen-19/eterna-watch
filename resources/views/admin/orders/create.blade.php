@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.orders.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Khách hàng</b></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div>
                                            <div>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#addUserModal">Chọn khách hàng</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addUserModalLabel">Chọn khách hàng</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="search-customer">Chọn khách
                                                    hàng</label>
                                                <select style="width: 100%" id="search-customer"
                                                    class="form-control border-primary shadow-sm">
                                                    <!-- Các option sẽ được load động hoặc tự thêm vào đây -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="card-body">
                                <div class="body row">

                                    <div class="mb-3 col-12">
                                        <label for="name" class="form-label">Họ tên</label>
                                        <input name="user_id" type="text" id="user_id" hidden>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name"
                                            class="form-control" placeholder="Nhập họ tên">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input value="{{ old('email') }}" name="email" type="email" id="email"
                                            class="form-control" placeholder="Nhập email">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input value="{{ old('phone') }}" name="phone" type="text" id="phone"
                                            class="form-control" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="city" class="form-label">Thành phố</label>
                                        <input value="{{ old('city') }}" name="city" type="text" id="city"
                                            class="form-control" placeholder="Nhập thành phố">
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="district" class="form-label">Quận</label>
                                        <input value="{{ old('district') }}" name="district" type="text" id="district"
                                            class="form-control" placeholder="Nhập quận">
                                        @error('district')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="ward" class="form-label">Phường</label>
                                        <input value="{{ old('ward') }}" name="ward" type="text" id="ward"
                                            class="form-control" placeholder="Nhập phường">
                                        @error('ward')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="detailed-address" class="form-label">Địa chỉ chi tiết</label>
                                        <input value="{{ old('street_address') }}" name="street_address" type="text"
                                            id="street_address" class="form-control" placeholder="Nhập địa chỉ chi tiết">
                                        @error('street_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Sản phẩm trong đơn hàng</b></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div>
                                            <div>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#addProductModal">Thêm sản phẩm</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog"
                                aria-labelledby="addProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addProductModalLabel">Thêm Sản Phẩm</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="productSelect">Chọn Sản Phẩm</label>
                                                <select id="productSelect" class="form-control select2"
                                                    style="width: 100%"></select>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="quantity">Số lượng</label>
                                                <input type="number" id="quantity" class="form-control" value="1"
                                                    min="1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Đóng</button>
                                            <button type="button" id="addProductBtn" class="btn btn-primary">Thêm Sản
                                                Phẩm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="body row">
                                    <div class="col-12">
                                        @if ($errors->has('order_items'))
                                            <div class="text-danger">{{ $errors->first('order_items') }}</div>
                                        @endif

                                        <table class="table table-bordered align-middle shadow-sm rounded"
                                            id="order-items">
                                            <thead class="table">
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot class="">
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bold"><b>Tạm tính</b></td>
                                                    <td colspan="2" class="text-end"><strong><span
                                                                id="total-price">0</span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bold"><b>Vận chuyển</b></td>
                                                    <td colspan="2" class="text-end"><strong><span
                                                                id="shipping_price">0</span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bold"><b>Khuyến mãi</b></td>
                                                    <td colspan="2" class="text-end"><strong><span
                                                                id="discount-price">0</span></strong></td>
                                                </tr>

                                                <tr class="">
                                                    <td colspan="3" class="text-end fw-bold"><b>Tổng thanh toán</b>
                                                    </td>
                                                    <td colspan="2" class="text-end"><strong><span
                                                                id="total_amount">0</span></strong></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                        <input type="hidden" id="total_amount_field" name="total_amount">
                                        <input type="hidden" id="voucher_id" name="voucher_id">

                                    </div>

                                </div>
                            </div>
                            <div class="card-header border-bottom-dashed" style="border-top: 1px solid #dee2e6;">
                                <div class="row g-4 align-items-center justify-content-between">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">Phương thức vận chuyển</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="shipping_method" id="shipping-method"
                                                class="form-select form-control" style="width: 288px;">
                                                <option value="">*Chọn hình thức vận chuyển</option>
                                                <option value="fixed">Giao hàng</option>
                                                <option value="store">Nhận tại cửa hàng</option>
                                            </select>
                                        </div>
                                        @error('shipping_method')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-header border-bottom-dashed" style="border-top: 1px solid #dee2e6;">
                                <div class="row g-4 align-items-center justify-content-between">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">Nhập mã giảm giá</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="text" id="discount-code" class="form-control"
                                                placeholder="Nhập mã tại đây" style="max-width: 200px;">
                                            <button id="checkVoucher" class="btn btn-info ml-2">Kiểm tra</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header border-bottom-dashed" style="border-top: 1px solid #dee2e6;">
                                <div class="row g-4 align-items-center justify-content-between">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">Phương thức thanh toán</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="payment_method" id="payment-method"
                                                class="form-select form-control" style="width: 288px;">
                                                <option value="cash">Tiền mặt</option>
                                                <option value="vnpay">VNPay</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header border-bottom-dashed" style="border-top: 1px solid #dee2e6;">
                                <div class="row g-4 align-items-center justify-content-between">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">Trạng thái thanh toán</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="payment_status" id="payment-status"
                                                class="form-select form-control" style="width: 288px;">
                                                <option value="pending">Chờ xử lý</option>
                                                <option value="completed">Hoàn thành</option>
                                                <option value="failed">Thất bại</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" id="add-btn">Tạo đơn mới</button>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ml-2">Đóng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </section>
    </div>
@endsection
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('script')
    <!-- Thêm vào cuối body hoặc layout master -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        document.querySelector('.close').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định
        });


        $(document).ready(function() {
            // Khởi tạo Select2 khi modal được hiển thị
            $('#addUserModal').on('shown.bs.modal', function() {
                $("#search-customer").select2({
                    dropdownParent: $('#addUserModal'), // Đảm bảo dropdown nằm trong modal
                    ajax: {
                        url: "{{ route('admin.orders.user-search') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(function(user) {
                                    return {
                                        id: user.id,
                                        text: user.name + " (" + user.email + ")",
                                        name: user.name,
                                        email: user.email,
                                        phone: user.phone,
                                        city: user.address ? (user.address.city ?? "") :
                                            "",
                                        district: user.address ? (user.address
                                            .district ?? "") : "",
                                        ward: user.address ? (user.address.ward ?? "") :
                                            "",
                                        street_address: user.address ? (user.address
                                            .street_address ?? "") : ""
                                    };
                                })
                            };
                        }
                    },
                    placeholder: "Tìm kiếm khách hàng...",
                    minimumInputLength: 2
                });
            });

            // Khi khách hàng được chọn, điền thông tin vào form
            $('#search-customer').on('select2:select', function(e) {
                let data = e.params.data;
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#city').val(data.city || "Không có thông tin");
                $('#district').val(data.district || "Không có thông tin");
                $('#ward').val(data.ward || "Không có thông tin");
                $('#street_address').val(data.street_address || "Không có thông tin");

                $('#addUserModal').modal('hide');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let appliedDiscount = 0;
            let shippingFee = 0;

            // Định dạng tiền tệ
            function formatCurrency(amount) {
                return Number(amount).toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }) + " VND";
            }

            // Chuyển chuỗi định dạng tiền tệ về số
            function parseCurrency(str) {
                return parseFloat(str.replace(/[^\d,.-]/g, '').replace(/\./g, '').replace(/,/g, '.')) || 0;
            }

            // Hiển thị sản phẩm trong dropdown Select2
            function formatProduct(product) {
                if (!product.id) return product.text;
                return $(`
                    <div class="d-flex align-items-center">
                        <img src="${product.image}" class="rounded me-2" width="50" height="50">
                        <span>${product.text} - ${formatCurrency(product.price)}</span>
                    </div>
                `);
            }

            function formatProductSelection(product) {
                return product.text || product.id;
            }

            $('#addProductModal').on('shown.bs.modal', function() {
                $('#productSelect').select2({
                    dropdownParent: $('#addProductModal'),
                    placeholder: "Chọn sản phẩm...",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('admin.products.search') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            search: params.term
                        }),
                        processResults: data => ({
                            results: data.results
                        }),
                        cache: true
                    },
                    templateResult: formatProduct,
                    templateSelection: formatProductSelection
                });
            });

            // Thêm sản phẩm vào bảng
            $('#addProductBtn').click(function() {
                let product = $('#productSelect').select2('data')[0];
                let quantity = parseInt($('#quantity').val());

                if (!product || quantity <= 0) {
                    alert('Vui lòng chọn sản phẩm và nhập số lượng hợp lệ!');
                    return;
                }

                let price = Number(product.price);
                let total = price * quantity;
                let index = $('#order-items tbody tr').length;

                let row = `
                    <tr data-id="${product.id}" data-index="${index}">
                        <td>
                            <img src="${product.image}" alt="${product.text}" width="60" style="margin-right: 10px;">
                            ${product.text}
                            <input type="hidden" name="order_items[${index}][id]" value="${product.id}">
                        </td>
                        <td class="align-middle">${formatCurrency(price)}</td>
                        <td class="align-middle">
                            <input type="number" name="order_items[${index}][quantity]"
                                class="form-control text-center update-quantity"
                                value="${quantity}" min="1" data-price="${price}" style="width: 60px;">
                        </td>
                        <td class="total-price align-middle">${formatCurrency(total)}</td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-danger btn-sm remove-product">Xóa</button>
                        </td>
                    </tr>`;
                $('#order-items tbody').append(row);
                updateTotalPrice();
                $('#addProductModal').modal('hide');
            });

            // Thay đổi phương thức vận chuyển
            $('#shipping-method').on('change', function() {
                shippingFee = $(this).val() === 'fixed' ? 100000 : 0;
                updateTotalPrice();
            });

            // Thay đổi số lượng sản phẩm
            $(document).on('input', '.update-quantity', function() {
                let qty = parseInt($(this).val()) || 0;
                let price = parseFloat($(this).data('price')) || 0;
                let total = qty * price;
                $(this).closest('tr').find('.total-price').text(formatCurrency(total));
                updateTotalPrice();
            });

            // Xóa sản phẩm
            $(document).on('click', '.remove-product', function() {
                $(this).closest('tr').remove();
                updateTotalPrice();
            });

            // Tính toán và cập nhật giá trị hiển thị
            function updateTotalPrice() {
                let subTotal = 0;

                $('#order-items tbody tr').each(function() {
                    let qty = parseInt($(this).find('.update-quantity').val()) || 0;
                    let price = parseFloat($(this).find('.update-quantity').data('price')) || 0;
                    subTotal += qty * price;
                });

                let finalTotal = subTotal - appliedDiscount + shippingFee;
                if (finalTotal < 0) finalTotal = 0;

                $('#total-price').text(formatCurrency(subTotal));
                $('#discount-price').text(formatCurrency(appliedDiscount));
                $('#shipping_price').text(formatCurrency(shippingFee));
                $('#total_amount').text(formatCurrency(finalTotal));
                $('#total_amount_field').val(finalTotal);
            }

            // Áp dụng mã giảm giá
            $('#checkVoucher').on('click', function(event) {
                event.preventDefault();
                let discountCode = $('#discount-code').val().trim();
                if (!discountCode) {
                    alert('Vui lòng nhập mã giảm giá.');
                    return;
                }

                let total = parseCurrency($('#total-price').text());

                $.ajax({
                    url: '{{ route('admin.vouchers.check') }}',
                    method: 'POST',
                    data: {
                        code: discountCode,
                        total: total,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.valid) {
                            alert(response.message);
                            appliedDiscount = response.discount || 0;
                            $('#voucher_id').val(response.voucher_id);
                            updateTotalPrice(); // Tự động cập nhật lại tổng tiền
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi:', error);
                        alert('Lỗi kiểm tra mã giảm giá. Vui lòng thử lại sau.');
                    }
                });
            });

        });
    </script>
@endsection
