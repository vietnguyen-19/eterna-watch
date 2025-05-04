@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Chỉnh sửa cài đặt</h5>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.settings.update', $setting->id) }}" autocomplete="off" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="body row">
                        <div class="mb-3 col-12">
                            <label for="key" class="form-label">Tên cài đặt</label>
                            <input name="key" value="{{ old('key', $setting->key) }}" key="key" type="text" id="key"
                                class="form-control" placeholder="Nhập tên cài đặt">
                            @error('key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12">
                            <label for="value" class="form-label">Nội dung</label>
                            <input name="value" value="{{ old('value', $setting->value) }}" type="text" id="value"
                                class="form-control" placeholder="Nhập nội dung">
                            @error('value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="hstack gap-2 justify-content-left">
                        <button type="submit" class="btn btn-success" id="add-btn">Cập nhật danh sách cài đặt</button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-light">Đóng</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->
<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->

<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->
<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->

<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->
<!-- <section itemscope itemtype="https://schema.org/UpdateAction">
  <meta itemprop="name" content="Chỉnh sửa dịch vụ {{ $service->name }}">
  <div itemprop="object" itemscope itemtype="https://schema.org/Service">
    <meta itemprop="identifier" content="{{ $service->id }}" />

    <h1>Chỉnh sửa dịch vụ: <span itemprop="name">{{ $service->name }}</span></h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div>
        <label for="name">Tên dịch vụ</label>
        <input type="text" name="name" id="name" value="{{ $service->name }}" itemprop="name">
      </div>

      <div>
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" itemprop="description">{{ $service->description }}</textarea>
      </div>

      @if ($service->image)
        <div>
          <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" itemprop="image">
        </div>
      @endif

      <div>
        <label for="image">Cập nhật ảnh (nếu cần)</label>
        <input type="file" name="image" id="image">
      </div>

      <button type="submit">Cập nhật</button>
    </form>
  </div>
</section> -->


@section('script-lib')
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.js/list.min.js"></script>
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js">
    </script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script')
    <script>
        document.getElementById('name').addEventListener('input', function() {
            // Lấy giá trị từ ô nhập liệu Tên danh mục
            var tenDanhMuc = this.value;

            // Chuyển đổi Tên danh mục thành Slug
            var slug = tenDanhMuc.toLowerCase()
                .normalize('NFD') // Chuẩn hóa Unicode để xử lý các ký tự tiếng Việt
                .replace(/[\u0300-\u036f]/g, '') // Xóa các dấu phụ
                .replace(/[^a-z0-9\s-]/g, '') // Xóa các ký tự đặc biệt không phải chữ cái Latin hoặc số
                .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-'); // Loại bỏ các dấu gạch ngang thừa

            // Gán giá trị Slug vào ô nhập liệu Slug
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection
