<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TransactionSettingController extends Controller
{
    protected $resourceDir = 'admin.transaction-setting';
    public function shippingMethods(){
        return view($this->resourceDir . '.shipping-method.index');
    }

    public function paymentMethods(){
        return view($this->resourceDir . '.payment-method.index');
    }
}
