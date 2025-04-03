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
                                        <input value="{{ old('specific_address') }}" name="specific_address"
                                            type="text" id="specific_address" class="form-control"
                                            placeholder="Nhập địa chỉ chi tiết">
                                        @error('specific_address')
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
                                        specific_address: user.address ? (user.address
                                            .specific_address ?? "") : ""
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
                $('#specific_address').val(data.specific_address || "Không có thông tin");

                $('#addUserModal').modal('hide');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Biến toàn cục để lưu giá trị khuyến mãi (có thể cập nhật khi áp voucher)
            var appliedDiscount = 0;

            // Khởi tạo Select2 khi modal "Thêm sản phẩm" được hiển thị
            $('#addProductModal').on('shown.bs.modal', function() {
                $('#productSelect').select2({
                    dropdownParent: $('#addProductModal'),
                    placeholder: "Chọn sản phẩm...",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('admin.products.search') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    },
                    templateResult: formatProduct,
                    templateSelection: formatProductSelection
                });
            });

            // Hiển thị sản phẩm kèm ảnh trong dropdown
            function formatProduct(product) {
                if (!product.id) {
                    return product.text;
                }
                let formattedPrice = Number(product.price).toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return $(`
            <div class="d-flex align-items-center">
                <img src="${product.image}" class="rounded me-2" width="50" height="50">
                <span>${product.text} - ${formattedPrice} VND</span>
            </div>
        `);
            }

            function formatProductSelection(product) {
                return product.text || product.id;
            }

            // Thêm sản phẩm vào bảng đơn hàng
            $('#addProductBtn').click(function() {
                let product = $('#productSelect').select2('data')[0]; // Lấy sản phẩm đã chọn
                let quantity = parseInt($('#quantity').val());

                if (!product || quantity <= 0) {
                    alert('Vui lòng chọn sản phẩm và nhập số lượng hợp lệ!');
                    return;
                }

                let price = Number(product.price);
                let total = price * quantity;
                let formattedPrice = price.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                let formattedTotal = total.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                // Xác định index của hàng mới dựa trên số hàng hiện có
                let index = $('#order-items tbody tr').length;

                // Mỗi hàng chứa thông tin sản phẩm và các input ẩn để gửi lên server
                let row = `
            <tr data-id="${product.id}" data-index="${index}">
                <td>
                    <img src="${product.image}" alt="${product.text}" width="60" style="margin-right: 10px;">
                    ${product.text}
                    <input type="hidden" name="order_items[${index}][id]" value="${product.id}">
                </td>
                <td class="align-middle">${formattedPrice} VND</td>
                <td class="align-middle">
                    <input type="number" name="order_items[${index}][quantity]" class="form-control text-center update-quantity" 
                           value="${quantity}" min="1" data-price="${product.price}" style="width: 60px;">
                </td>
                <td class="total-price align-middle">${formattedTotal} VND</td>
                <td class="align-middle">
                    <button type="button" class="btn btn-danger btn-sm remove-product">Xóa</button>
                </td>
            </tr>
        `;

                $('#order-items tbody').append(row);
                updateTotalPrice();
                $('#addProductModal').modal('hide'); // Đóng modal
            });

            // Cập nhật tổng tiền khi thay đổi số lượng
            $(document).on('input', '.update-quantity', function() {
                let quantity = parseInt($(this).val());
                let price = parseFloat($(this).data('price'));
                let total = quantity * price;
                $(this).closest('tr').find('.total-price').text(
                    total.toLocaleString('vi-VN', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }) + " VND"
                );
                updateTotalPrice();
            });

            // Xóa sản phẩm khỏi đơn hàng
            $(document).on('click', '.remove-product', function() {
                $(this).closest('tr').remove();
                updateTotalPrice();
            });

            // Hàm cập nhật tổng tiền (tạm tính, khuyến mãi và tổng thanh toán)
            function updateTotalPrice() {
                let subTotal = 0;
                $('#order-items tbody tr').each(function() {
                    let qty = parseInt($(this).find('.update-quantity').val());
                    let price = parseFloat($(this).find('.update-quantity').data('price'));
                    subTotal += qty * price;
                });

                // Hiển thị tạm tính
                let formattedSubTotal = subTotal.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }) + " VND";
                $('#total-price').text(formattedSubTotal);

                // Khuyến mãi (ở đây dùng appliedDiscount; nếu chưa áp voucher thì = 0)
                let discount = appliedDiscount;
                let formattedDiscount = discount.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }) + " VND";
                $('#discount-price').text(formattedDiscount);

                // Tổng thanh toán = Tạm tính - Khuyến mãi
                let finalTotal = subTotal - discount;
                if (finalTotal < 0) finalTotal = 0;
                let formattedFinalTotal = finalTotal.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }) + " VND";
                $('#total_amount').text(formattedFinalTotal);

                // Cập nhật input ẩn gửi lên server
                $('#total_amount_field').val(finalTotal);
                
            }
        });
    </script>
    <script>
        $('#checkVoucher').on('click', function(event) {
            event.preventDefault(); // Ngăn không cho form submit

            // Lấy mã giảm giá từ input
            var discountCode = $('#discount-code').val();

            // Lấy giá trị tổng thanh toán ban đầu (Tạm tính)
            var totalStr = $('#total-price').text();

            // Loại bỏ ký tự không phải số, xử lý định dạng vi-VN
            var totalClean = totalStr.replace(/[^\d,.-]/g, '').replace(/\./g, '').replace(/,/g, '.');
            var total = parseFloat(totalClean);

            // Kiểm tra nếu người dùng chưa nhập mã giảm giá
            if (!discountCode) {
                alert('Vui lòng nhập mã giảm giá.');
                return;
            }

            // Gửi yêu cầu Ajax tới backend
            $.ajax({
                url: '{{ route('admin.vouchers.check') }}',
                method: 'POST',
                data: {
                    code: discountCode,
                    total: total,
                    _token: '{{ csrf_token() }}' // Đảm bảo có token CSRF
                },
                success: function(response) {
                    if (response.valid) {
                        // Hiển thị thông báo thành công
                        alert(response.message);
                        var voucher_id = response.voucher_id;
                        // Định dạng số theo vi-VN
                        var formattedDiscount = Number(response.discount).toLocaleString('vi-VN', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }) + " VND";

                        var formattedNewTotal = Number(response.newTotal).toLocaleString('vi-VN', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }) + " VND";

                        // Cập nhật giá trị trên giao diện
                        $('#discount-price').text(formattedDiscount); // Cập nhật khuyến mãi
                        $('#total_amount').text(formattedNewTotal); // Cập nhật tổng thanh toán
                        $('#total_amount_field').val(total);
                        $('#voucher_id').val(voucher_id);

                    } else {
                        // Hiển thị thông báo lỗi
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Đã xảy ra lỗi:', error);
                    alert('Lỗi kiểm tra mã giảm giá. Vui lòng thử lại sau.');
                }
            });
        });
    </script>
@endsection
