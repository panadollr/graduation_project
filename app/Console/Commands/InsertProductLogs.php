<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Models\Product;
use Illuminate\Console\Command;

class InsertProductLogs extends Command
{
    protected $signature = 'log:insert-products'; // Tên lệnh khi chạy command
    protected $description = 'Insert logs for product creation into the logs table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy danh sách tất cả sản phẩm trong bảng products
        $products = Product::all();

        // Duyệt qua từng sản phẩm và insert log vào bảng logs
        foreach ($products as $product) {
            // Tạo một bản ghi log cho mỗi sản phẩm
            Log::create([
                'user_id' => 2, // User ID cố định
                'action' => "Đã nhập kho cho sản phẩm có ID: {$product->id}, Số lượng nhập kho: {$product->quantity}",
                'created_at' => $product->created_at,
                'updated_at' => $product->created_at,
            ]);

            // Hiển thị thông báo mỗi khi insert log thành công
            $this->info("Log for product ID: {$product->id} inserted successfully.");
        }
    }
}
