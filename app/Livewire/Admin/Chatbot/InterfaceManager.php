<?php

namespace App\Livewire\Admin\Chatbot;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class InterfaceManager extends Component
{
    use WithFileUploads;

    public $chatbotData = [
        'name' => '',
        'icon' => null,
    ];

    public $logoPreview = null;
    public $iconPreview = null;

    protected $rules = [
        'chatbotData.name' => 'required|string|max:255',
        'chatbotData.logo' => 'nullable|image|max:2048', // Tối đa 2MB
    ];

    // Phương thức mount để lấy dữ liệu từ cơ sở dữ liệu
    public function mount()
    {
        // Lấy thông tin từ bảng settings và gán vào chatbotData
        $this->chatbotData['name'] = Setting::where('key', 'chatbot_name')->value('value') ?? '';
        $this->chatbotData['logo'] = Setting::where('key', 'chatbot_logo')->value('value') ?? null;

        // Nếu đã có logo, set logoPreview
        if ($this->chatbotData['logo']) {
            $this->logoPreview = asset('storage/' . $this->chatbotData['logo']);
        }

        // Nếu đã có icon, set iconPreview
        if ($this->chatbotData['icon']) {
            $this->iconPreview = asset('storage/' . $this->chatbotData['icon']);
        }
    }
    

    public function updatedChatbotDataLogo()
    {
        $this->validateOnly('chatbotData.logo');
        $this->logoPreview = $this->chatbotData['logo']->temporaryUrl();
    }

    public function deleteLogo()
    {
        // Xóa logo từ cơ sở dữ liệu và file hệ thống
        $currentLogo = Setting::where('key', 'chatbot_logo')->value('value');
        if ($currentLogo && file_exists(storage_path('app/public/' . $currentLogo))) {
            unlink(storage_path('app/public/' . $currentLogo));
        }
        Setting::where('key', 'chatbot_logo')->delete();
        $this->chatbotData['logo'] = null;
        $this->logoPreview = null;
        session()->flash('message', 'Logo đã được xóa thành công!');
    }

    public function saveChatbotSettings()
    {
        $this->validate();

        // Xử lý upload file logo
        if ($this->chatbotData['logo']) {
            $logoPath = $this->chatbotData['logo'] = $this->chatbotData['logo']->store('chatbot/logos', 'public');
            Setting::updateOrCreate(
                ['key' => 'chatbot_logo'],  // Tìm key 'chatbot_logo'
                ['value' => $logoPath]      // Lưu đường dẫn file logo vào trường value
            );
        }

        // Cập nhật thông tin chatbot nếu cần
        Setting::updateOrCreate(
            ['key' => 'chatbot_name'], 
            ['value' => $this->chatbotData['name']]
        );

        session()->flash('message', 'Cài đặt giao diện chatbot đã được lưu thành công!');
    }

    public function resetForm()
    {
        $this->reset('chatbotData', 'logoPreview', 'iconPreview');
    }

    public function render()
    {
        return view('admin.chatbot.interface.livewire.manager');
    }
}
