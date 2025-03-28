@extends('admin.layouts.master')

@section('title', 'Tạo Voucher Mới')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tạo Voucher Mới</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Tên Voucher <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="code">Mã Voucher <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount_type">Loại Giảm Giá <span class="text-danger">*</span></label>
                    <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror" required>
                        <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giá trị cố định</option>
                    </select>
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount_value">Giá trị giảm giá <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}" min="0" step="0.01" required>
                    @error('discount_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="min_order">Đơn hàng tối thiểu</label>
                    <input type="number" name="min_order" id="min_order" class="form-control @error('min_order') is-invalid @enderror" value="{{ old('min_order') }}" min="0">
                    @error('min_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_uses">Số lần sử dụng tối đa</label>
                    <input type="number" name="max_uses" id="max_uses" class="form-control @error('max_uses') is-invalid @enderror" value="{{ old('max_uses') }}" min="1">
                    @error('max_uses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expires_at">Ngày hết hạn</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                    @error('expires_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Tạo Voucher</button>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
