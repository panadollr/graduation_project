<?php

namespace App\Livewire\Client\Account;

use App\Models\Setting;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyAddresses extends Component
{
    public $addresses = [];
    public $name, $phone, $address, $is_default = false, $isModalOpen = false;
    public $modalTitle = '', $saveButtonText = '', $editId = null;
    public $tinhList = [], $quanList = [], $phuongList = [];
    public $tinh = null, $quan = null, $phuong = null;

    public function mount()
    {
        $this->loadAddresses();
        $this->loadTinh();
    }

    public function loadAddresses()
    {
        $this->addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->get()
            ;

            // Load danh sách quận dựa trên các thành phố có trong danh sách địa chỉ
        $cityIds = array_unique(array_column($this->addresses->toArray(), 'city'));
        foreach ($cityIds as $cityId) {
            $this->quanList[$cityId] = $this->loadQuanForCity($cityId);
        }

        $districtIds = array_unique(array_column($this->addresses->toArray(), 'district'));
        foreach ($districtIds as $districtId) {
            $this->phuongList[$districtId] = $this->loadPhuongForDistrict($districtId);
        }
    }

    public function loadTinh()
    {
        $this->tinhList = Setting::where('key', 'cities')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                    'name' => $item->name, // Lấy tên từ cột `name`
                ];
            })
            ->toArray();
    }

    public function updatedTinh(){
        $this->loadQuan($this->tinh);
    }

    public function updatedQuan(){
        $this->loadPhuong($this->quan);
    }

    private function loadQuanForCity($cityId)
    {
        return Setting::where('key', 'districts')
            ->whereJsonContains('value->parent_id', $cityId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                    'parent_id' => json_decode($item->value, true)['parent_id'], // Lấy ID từ JSON trong cột `value`
                    'name' => $item->name, // Lấy tên từ cột `name`
                ];
            })
            ->toArray();
    }

    private function loadPhuongForDistrict($districtId)
    {
        return Setting::where('key', 'wards')
            ->whereJsonContains('value->parent_id', $districtId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                    'parent_id' => json_decode($item->value, true)['parent_id'], // Lấy ID từ JSON trong cột `value`
                    'name' => $item->name, // Lấy tên từ cột `name`
                ];
            })
            ->toArray();
    }

    public function loadQuan($tinhId)
    {
        $this->resetQuanAndPhuong();
        $this->quanList = $this->loadQuanForCity($tinhId);
    }

    public function loadPhuong($quanId)
    {
        $this->phuongList = $this->loadPhuongForDistrict($quanId);
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->modalTitle = 'Thêm địa chỉ mới';
        $this->saveButtonText = 'Thêm địa chỉ';
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function saveAddress()
    { 
        try {        
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'tinh' => 'required',    // Kiểm tra thành phố
            'quan' => 'required',    // Kiểm tra quận huyện
            'phuong' => 'required',  // Kiểm tra phường xã
        ]);

        if ($this->editId) {
            // Update address
            $address = UserAddress::find($this->editId);
            $address->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'city' => $this->tinh,
                'district' => $this->quan,
                'ward' => $this->phuong,
                'address' => $this->address,
            ]);
        } else {
            // Kiểm tra nếu đây là địa chỉ đầu tiên của người dùng
            $isDefault = UserAddress::where('user_id', Auth::id())->count() === 0;
            // Add new address
            UserAddress::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'phone' => $this->phone,
                'city' => $this->tinh,
                'district' => $this->quan,
                'ward' => $this->phuong,
                'address' => $this->address,
                'is_default' => $isDefault
            ]);
            $this->tinh = null;
        }

        $this->closeModal();
        $this->loadAddresses();
    } catch (\Throwable $th) {
       dd($th->getMessage());
    }
    }

    public function editAddress($id)
    {
        $address = UserAddress::findOrFail($id);
        $this->editId = $id;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->tinh = $address->city;
        $this->loadQuan($this->tinh);
        $this->quan = $address->district;
        $this->loadPhuong($this->quan);
        $this->phuong = $address->ward;
        $this->address = $address->address;
        $this->is_default = $address->is_default;
        $this->modalTitle = 'Cập nhật địa chỉ';
        $this->saveButtonText = 'Lưu thay đổi';
        // Load dependent lists
        $this->isModalOpen = true;
    }

    public function deleteAddress($id)
    {
        UserAddress::destroy($id);
        $this->loadAddresses();
    }

    public function setDefaultAddress($id)
    {
        UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        $address = UserAddress::find($id);
        $address->update(['is_default' => true]);
        $this->loadAddresses();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->editId = null;
        $this->resetQuanAndPhuong();
    }

    private function resetQuanAndPhuong()
    {
        $this->quan = null;
        $this->phuong = null;
        $this->quanList = [];
        $this->phuongList = [];
    }

    public function render()
    {
        return view('livewire.client.account.my-addresses')
        ->extends('client.account.layout')
        ->section('main')
        ->layoutData(['title' => 'Địa chỉ của tôi']);
    }
}
