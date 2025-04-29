<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHandler
{
    /**
     * Lưu ảnh mới và trả về đường dẫn lưu
     *
     * @param UploadedFile $file  File ảnh upload
     * @param string $folder      Tên thư mục con trong public/storage
     * @return string             Đường dẫn tương đối để lưu vào DB
     */
    public static function saveImage(UploadedFile $file, $folder = 'uploads')
    {
        // Tạo thư mục nếu chưa có
        $destinationPath = public_path("storage/$folder");

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Tạo tên file mới
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Di chuyển file
        $file->move($destinationPath, $fileName);

        // Trả về đường dẫn tương đối
        return "$folder/$fileName";
    }

    /**
     * Cập nhật ảnh (xóa ảnh cũ nếu có, sau đó lưu mới)
     *
     * @param UploadedFile $file  File ảnh mới
     * @param string|null $oldPath Đường dẫn ảnh cũ (nếu có)
     * @param string $folder      Thư mục lưu trữ
     * @return string             Đường dẫn ảnh mới
     */
    public static function updateImage(UploadedFile $file, $oldPath = null, $folder = 'uploads')
    {
        // Xóa ảnh cũ nếu có
        if ($oldPath) {
            self::deleteImage($oldPath);
        }

        // Lưu ảnh mới
        return self::saveImage($file, $folder);
    }

    /**
     * Xóa ảnh
     *
     * @param string $path  Đường dẫn tương đối (ví dụ: uploads/abc.jpg)
     * @return void
     */
    public static function deleteImage($path)
    {
        $fullPath = public_path("storage/$path");

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
