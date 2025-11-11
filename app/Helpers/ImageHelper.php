<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Kompres dan ubah ukuran gambar.
     * Mengembalikan resource image yang sudah dikompres (tidak menyimpan file).
     *
     * @param string $sourcePath   Path file gambar sumber.
     * @param int    $quality      Kualitas kompres (0–100)
     * @param int    $maxWidth     Batas lebar maksimum
     * @param int    $maxHeight    Batas tinggi maksimum
     * @return array               ['image' => resource, 'extension' => string]
     */
    public static function compressImage($sourcePath, $quality = 75, $maxWidth = 1280, $maxHeight = 1280)
    {
        ini_set('memory_limit', '1024M');

        $info = getimagesize($sourcePath);
        if (!$info) {
            throw new \Exception("File bukan gambar yang valid: $sourcePath");
        }

        list($width, $height) = $info;
        $ratio = $width / $height;

        // Tentukan ukuran baru
        if ($width > $maxWidth || $height > $maxHeight) {
            if ($ratio > 1) {
                $newWidth = $maxWidth;
                $newHeight = (int) round($maxWidth / $ratio);
            } else {
                $newHeight = $maxHeight;
                $newWidth = (int) round($maxHeight * $ratio);
            }
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        // Baca file gambar sesuai mime
        switch ($info['mime']) {
            case 'image/jpeg':
                $image = \imagecreatefromjpeg($sourcePath);
                $ext = 'jpg';
                break;
            case 'image/png':
                $image = \imagecreatefrompng($sourcePath);
                $ext = 'png';
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = \imagecreatefromwebp($sourcePath);
                    $ext = 'webp';
                } else {
                    // fallback aman
                    $image = \imagecreatefromstring(file_get_contents($sourcePath));
                    $ext = 'jpg';
                }
                break;
            default:
                $image = \imagecreatefromstring(file_get_contents($sourcePath));
                $ext = 'jpg';
        }

        // Resize hasil
        $newImage = \imagecreatetruecolor($newWidth, $newHeight);

        // Transparansi (PNG & WebP)
        if ($ext === 'png' || $ext === 'webp') {
            \imagealphablending($newImage, false);
            \imagesavealpha($newImage, true);
            $transparent = \imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            \imagefill($newImage, 0, 0, $transparent);
        }

        \imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Bersihkan resource lama
        \imagedestroy($image);

        // Return hasilnya, biar controller yang simpan
        return [
            'image' => $newImage,
            'extension' => $ext,
            'quality' => $quality
        ];
    }

    /**
     * Simpan resource image ke file sesuai ekstensi.
     * Ini optional helper kalau kamu ingin gunakan di controller.
     */
    public static function saveImage($imageResource, $destinationPath, $extension, $quality = 75)
    {
        switch ($extension) {
            case 'png':
                $pngQuality = 9 - floor(($quality / 100) * 9);
                imagepng($imageResource, $destinationPath, $pngQuality);
                break;
            case 'webp':
                if (function_exists('imagewebp')) {
                    imagewebp($imageResource, $destinationPath, $quality);
                    break;
                }
                // fallback ke jpg jika webp tidak didukung
            default:
                imagejpeg($imageResource, $destinationPath, $quality);
        }
        imagedestroy($imageResource);
    }

    /**
     * Ganti base64 image di dalam konten HTML menjadi file statis.
     * (Masih menyimpan file, karena ini khusus konten dengan <img src="data:...">)
     */
    public static function saveBase64Images($content)
    {
        preg_match_all('/<img[^>]+src="data:image\/([^;]+);base64,([^"]+)"/', $content, $matches);

        foreach ($matches[0] as $index => $imgTag) {
            $extension = strtolower($matches[1][$index]);
            $base64Data = $matches[2][$index];
            $imageData = base64_decode($base64Data);
            if (!$imageData) continue;

            if (!in_array($extension, ['png', 'jpg', 'jpeg', 'webp'])) {
                $extension = 'jpg';
            }

            $fileName = uniqid('blog_inline_') . '.' . $extension;
            $filePath = storage_path('app/public/blog/' . $fileName);
            file_put_contents($filePath, $imageData);

            $url = asset('storage/blog/' . $fileName);
            $newImgTag = str_replace($matches[0][$index], '<img src="' . $url . '"', $imgTag);
            $content = str_replace($imgTag, $newImgTag, $content);
        }

        return $content;
    }
}
