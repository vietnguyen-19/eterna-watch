<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {


        if (!$request->hasFile('avatar')) {
            return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
        }

        $file = $request->file('avatar');

        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid image'], 400);
        }

        // Tạo tên file mới để tránh trùng
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Đường dẫn lưu file vào thư mục public/storage/products
        $destinationPath = public_path('storage/products');

        // Kiểm tra nếu thư mục chưa tồn tại thì tạo mới
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Di chuyển file vào thư mục đích
        $file->move($destinationPath, $fileName);

        // Trả về đường dẫn public có thể truy cập ảnh
        $publicPath =  'products/' . $fileName;

        return response()->json([
            'success' => true,
            'message' => 'Upload thành công',
            'path' => $publicPath
        ]);
    }

    public function removeImage(Request $request)
    {
        // Lấy dữ liệu từ body của request
        $filePath = $request->getContent();

        // Kiểm tra xem dữ liệu có phải JSON không
        $decodedData = json_decode($filePath, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // Nếu là JSON, lấy giá trị từ mảng (giả sử có key "path")
            $filePath = $decodedData['path'] ?? null;
        }

        if (empty($filePath)) {
            return response()->json(['success' => false, 'message' => 'File path is empty'], 400);
        }

        // Đường dẫn đầy đủ tới file trong thư mục storage
        $storagePath = public_path('storage/' . $filePath);

        if (file_exists($storagePath)) {
            unlink($storagePath);
            return response()->json(['success' => true, 'message' => 'File deleted']);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }
}
