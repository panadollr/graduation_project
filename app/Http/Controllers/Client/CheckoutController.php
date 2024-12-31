<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Sku;
use App\Models\UserAddress;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    protected $resourceDir = 'client.checkout';
    public function index(Request $request){
        $checkoutProductsInput = $request->input('checkoutProducts');   
        $checkoutProducts = collect();

        if(isset($checkoutProductsInput)){
            // Lấy tất cả sản phẩm dựa trên product_id
            $productIds = collect($checkoutProductsInput)->pluck('product_id'); // Lấy tất cả product_id từ checkoutProducts
            $products = Product::whereIn('id', $productIds)->get(); // Lấy thông tin sản phẩm

            // Gắn thông tin sản phẩm vào checkoutProducts
            $checkoutProducts = collect($checkoutProductsInput)->map(function ($product) use ($products) {
                $productData = $products->firstWhere('id', $product['product_id']);
                
                // Kết hợp thông tin sản phẩm và quantity
                return [
                    'id' => $productData->id,
                    'name' => $productData->name,
                    'slug' => $productData->slug,
                    'sale_price' => $productData->sale_price,
                    'featured_image' => $productData->featured_image,
                    'quantity' => $product['quantity'], // Thêm quantity vào
                ];
            });
        } else {
            $cartItems = Cart::with('product')->get();
            $checkoutProducts = collect($cartItems)->map(function ($cart) {
                $product = $cart->product;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'sale_price' => $product->sale_price,
                    'featured_image' => $product->featured_image,
                    'quantity' => $cart->quantity,
                ];
            });
        }

        // Redirect if no products are available for checkout
        if ($checkoutProducts->isEmpty() || $checkoutProducts->sum('quantity') <= 0) {
            abort(500);
        }
        
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        $addresses = UserAddress::where('user_id', $user->id)->get();
        
        // $tinhList = $this->loadTinh();

        // $quanList = [];
        // $cityIds = $addresses->pluck('city')->unique();
        // foreach ($cityIds as $cityId) {
        //     $quanList[$cityId] = $this->loadQuanForCity($cityId);
        // }

        // $phuongList = [];
        // $districtIds = $addresses->pluck('district')->unique();
        // foreach ($districtIds as $districtId) {
        //     $phuongList[$districtId] = $this->loadPhuongForDistrict($districtId);
        // }
        $shippingMethods = ShippingMethod::all();

        return view($this->resourceDir . '.index', compact('addresses', 'checkoutProducts', 'shippingMethods'));
    }

    private function loadQuanForCity($cityId)
    {
        $response = Http::get("https://esgoo.net/api-tinhthanh/2/{$cityId}.htm");
        if ($response->successful()) {
            $data = $response->json();
            if ($data['error'] === 0) {
                return $data['data'];
            }
        }
        return [];
    }

    private function loadTinh()
    {
        $response = Http::get('https://esgoo.net/api-tinhthanh/1/0.htm');
        if ($response->successful()) {
            $data = $response->json();
            if ($data['error'] === 0) {
                return $data['data'];
            }
        }
        return [];
    }

    private function loadPhuongForDistrict($districtId)
    {
        $response = Http::get("https://esgoo.net/api-tinhthanh/3/{$districtId}.htm");
        if ($response->successful()) {
            $data = $response->json();
            if ($data['error'] === 0) {
                return $data['data'];
            }
        }
        return [];
    }

    public function vnpayReturn(Request $request){
        // dd($request->all());
         // Check the VNPay transaction status
        if ($request->vnp_TransactionStatus == '00') {
            return redirect()->route('checkout.success');
        } else {
            $vnpayService = new VNPayService();
            $errorMessage = $vnpayService->getVNPayErrorMessage($request->vnp_TransactionStatus);
            return redirect()->route('checkout.index')->withErrors($errorMessage);
        }
    }

    public function checkoutSuccess(){
        return view($this->resourceDir . '.success');
    }
}
