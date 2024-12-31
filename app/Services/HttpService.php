<?php

// app/Services/HttpService.php

namespace App\Services;

class HttpService
{
    /**
     * Gửi yêu cầu HTTP POST đến API và trả về kết quả dưới dạng mảng.
     *
     * @param string $url Địa chỉ API cần gửi đến
     * @param array $data Dữ liệu cần gửi đi (mảng PHP)
     * @return array|null Kết quả trả về dưới dạng mảng hoặc null nếu có lỗi
     */
    public static function sendPostRequest($url, $data)
    {
        // Mã hóa dữ liệu thành JSON
        $jsonData = json_encode($data);

        // Cấu hình các tuỳ chọn HTTP
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $jsonData
            ]
        ];

        // Tạo context và gửi yêu cầu
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);  // Dùng "@" để ngăn thông báo lỗi PHP

        // Kiểm tra và xử lý lỗi
        if ($response === FALSE) {
            return null;  // Trả về null nếu có lỗi
        }

        // Giải mã JSON và trả về mảng
        return json_decode($response, true);
    }
}
