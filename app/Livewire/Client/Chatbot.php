<?php

namespace App\Livewire\Client;

use App\Models\ChatbotMessage;
use App\Models\Setting;
use App\Services\Chatbot\LanTechAI;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Chatbot extends Component
{
    public $prompt = ''; // Tin nhắn hiện tại của người dùng
    public $messages = []; // Danh sách tin nhắn trong đoạn hội thoại
    public $isTyping = false; // Trạng thái hiển thị bot đang gõ
    public $showChatForm = false; // Hiển thị hoặc ẩn form chat
    public $userId = null; // ID của người dùng đã đăng nhập hoặc UUID của khách
    public $isGuest = false; // Kiểm tra người dùng có phải khách không
    public $question = '';
    public $answer = '';

    /**
     * Hàm khởi tạo, thiết lập ban đầu cho component.
     */
    public function mount()
    {
        $this->userId = Auth::check() ? Auth::id() : session('guest_id', (string) Str::uuid());
        $this->isGuest = !Auth::check();

        if ($this->isGuest) {
            session()->put('guest_id', $this->userId);
        }

        // Tải tin nhắn từ cơ sở dữ liệu
        $this->loadMessages();
    }

    /**
     * Tải lịch sử tin nhắn từ cơ sở dữ liệu.
     */
    private function loadMessages()
    {
        $this->messages = ChatbotMessage::query()
            ->where($this->isGuest ? 'guest_id' : 'user_id', $this->userId)
            ->orderBy('created_at', 'asc')
            ->get(['sender as type', 'message as content'])
            ->toArray();
    }

    /**
     * Xử lý khi người dùng gửi tin nhắn.
     */
    public function sendMessage()
    {
        if (empty($this->prompt)) {
            return; 
        }

        $this->question = $this->prompt;
 
        $this->prompt = '';
 
        $this->js('$wire.ask()');

        // Thêm tin nhắn của người dùng vào danh sách
        $this->addMessage('user', $this->question);
        $this->isTyping = true; // Hiển thị trạng thái bot đang gõ
    }

    /**
     * Xử lý phản hồi từ chatbot.
     */
    function ask()
    {
        try {
            $response = LanTechAI::ask($this->question, $this->userId);
            
            $this->addMessage('bot', $response ?: 'Rất tiếc, tôi không thể xử lý yêu cầu của bạn ngay lúc này.');
        } catch (\Exception $e) {
            $this->addMessage('bot', 'Đã xảy ra lỗi khi xử lý tin nhắn của bạn. Vui lòng thử lại sau.');
        } finally {
            $this->isTyping = false; // Tắt trạng thái bot đang gõ
        }
    }

    /**
     * Thêm một tin nhắn vào đoạn hội thoại và lưu vào cơ sở dữ liệu.
     */
    private function addMessage($type, $content)
    {
        $message = [
            'type' => $type, // Loại tin nhắn (user hoặc bot)
            'content' => $content, // Nội dung tin nhắn
        ];

        $this->messages[] = $message;

        // Lưu tin nhắn vào cơ sở dữ liệu
        ChatbotMessage::create([
            'user_id' => $this->isGuest ? null : $this->userId,
            'guest_id' => $this->isGuest ? $this->userId : null,
            'sender' => $type,
            'message' => $content,
        ]);
    }

    /**
     * Xóa tất cả tin nhắn của người dùng hiện tại (đăng nhập hoặc khách).
     */
    public function deleteMessages()
    {
        ChatbotMessage::where($this->isGuest ? 'guest_id' : 'user_id', $this->userId)->delete();
        $this->messages = [];
    }

    /**
     * Render giao diện Livewire component.
     */
    public function render()
    {
        $chatbotSettings = Setting::whereIn('key', ['chatbot_name'])->get();
        return view('livewire.client.chatbot', [
            'messages' => $this->messages, // Danh sách tin nhắn
            'isTyping' => $this->isTyping, // Trạng thái bot đang gõ
            'chatbotSettings' => $chatbotSettings
        ]);
    }
}
