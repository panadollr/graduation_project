<?php

// app/Services/HttpService.php

namespace App\Services;

use NumberFormatter;

class CurrencyService
{
    /**
     * Định dạng số thành tiền Việt Nam.
     *
     * @param float|int $amount
     * @return string
     */
    public static function formatVND($amount)
    {
        $formatter = new NumberFormatter('vi_VN', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'VND');
    }
}
