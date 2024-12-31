<?php

use Carbon\Carbon;

/**
     * Định dạng số thành tiền Việt Nam.
     *
     * @param float|int $amount
     * @return string
*/
if (! function_exists('formatVND')) {
    function formatVND($amount)
    {
        $formatter = new NumberFormatter('vi_VN', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'VND');
    }

}

/**
     * Rút gọn chuỗi string.
     *
     * @param string $string
     * @param int $limit
     * @return string
*/
if (! function_exists('limitString')) {
    function limitString($string, $limit)
    {
        return \Illuminate\Support\Str::limit($string, $limit);
    }

}

/**
 * Định dạng timestamp thành thời gian tương đối (ví dụ: "1 phút trước", "1 ngày trước").
 *
 * @param string|int $timestamp
 * @return string
 */
if (! function_exists('formatTimestamp')) {
    function formatTimestamp($timestamp)
    {
        // Chuyển đổi timestamp sang Carbon instance
        $carbonInstance = Carbon::parse($timestamp);
        
        // Trả về thời gian dạng "1 phút trước", "1 ngày trước", ...
        return $carbonInstance->diffForHumans();
    }
}

  
/**
 * Hiển thị số điện thoại an toàn.
 *
 * @param string $phone
 * @return string
 */
if (! function_exists('safePhoneDisplay')) {
    function safePhoneDisplay($phone)
    {
        return substr($phone, 0, 3) . str_repeat('*', strlen($phone) - 6) . substr($phone, -3);
    }
}

/**
 * Tạo slug từ chuỗi.
 *
 * @param string $string
 * @return string
 */
if (! function_exists('generateSlug')) {
    function generateSlug($string)
    {
        return \Illuminate\Support\Str::slug($string, '-');
    }
}


/**
 * Định dạng ngày hiển thị.
 *
 * @param string|Carbon $date
 * @return string
 */
if (! function_exists('formatDateDisplay')) {
    function formatDateDisplay($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}


/**
 * Tính tổng tiền từ danh sách sản phẩm.
 *
 * @param array $items
 * @param string $priceKey
 * @param string $quantityKey
 * @return float
 */
if (! function_exists('calculateTotalPrice')) {
    function calculateTotalPrice($items, $priceKey = 'price', $quantityKey = 'quantity')
    {
        return array_reduce($items, function ($carry, $item) use ($priceKey, $quantityKey) {
            return $carry + ($item[$priceKey] * $item[$quantityKey]);
        }, 0);
    }
}

