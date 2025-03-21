<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Quản lý Bài viết')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('admin.articles.index') }}">Trang Quản Lý</a>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>
