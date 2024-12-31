<?php
namespace App\Services;

class VNPayService
{
    public function createPaymentUrl($orderData)
    {
        $vnp_Url = env("VNP_URL");//URL thanh toán của VNPAY
        $vnp_Returnurl = route('checkout.vnpay-return');
        $vnp_TmnCode = env("VNP_TMN_CODE");//Mã website tại VNPAY 
        $vnp_HashSecret = env("VNP_HASH_SECRET"); //Chuỗi bí mật
        
        $vnp_TxnRef = $orderData['order_id'];
        $vnp_OrderInfo = $orderData['description'];
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $orderData['amount'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    public function getVNPayErrorMessage($transactionStatus)
    {
        $errorMessages = [
            '01' => 'Giao dịch chưa hoàn tất.',
            '02' => 'Giao dịch bị lỗi.',
            '04' => 'Giao dịch đảo. Khách hàng đã bị trừ tiền tại Ngân hàng nhưng giao dịch chưa thành công ở VNPAY.',
            '05' => 'VNPAY đang xử lý giao dịch này (GD hoàn tiền).',
            '06' => 'VNPAY đã gửi yêu cầu hoàn tiền sang Ngân hàng.',
            '07' => 'Giao dịch bị nghi ngờ gian lận.',
            '09' => 'Giao dịch hoàn trả bị từ chối.',
        ];
    
        return $errorMessages[$transactionStatus] ?? 'Giao dịch không thành công. Vui lòng thử lại.';
    }
}
