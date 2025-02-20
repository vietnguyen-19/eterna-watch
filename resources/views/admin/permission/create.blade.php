<h1>Tạo mới permission</h1>
<form action="{{ route('admin.permissions.store') }}" method="post">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name">
    <button type="submit">Tạo mới</button>
</form>