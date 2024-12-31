<div x-data="{ showChat: false, isReady: false }" x-init="setTimeout(() => isReady = true, 300)">    
    <link rel="stylesheet" href="{{ asset('client/assets/css/chatbot.css') }}">

    <div class="chat-box-container">
        <!-- Floating AI button -->
        <div class="ai-chat-button" x-show="isReady" 
        x-transition style="display: none;" @click="showChat = ! showChat; isReady  = !isReady">
           <img src="{{ asset('client/assets/images/chatbot-icon.png') }}" alt="" srcset="">
        </div>

        <!-- Chat Form -->
            <form wire:submit.prevent="sendMessage" class="chat-box" x-transition x-show="showChat" style="display: none">
                <!-- Chat Header -->
                <div class="chat-header" >
                    <img src="{{ asset('client/assets/images/chatbot-icon.png')}}" alt="Avatar">
                    <div>
                        <div class="name">{{ $chatbotSettings->where('key', 'chatbot_name')->value('value') }}</div>
                    </div>
                    <!-- Minimize Button -->
                    <div class="minimize-button" @click="showChat = ! showChat; isReady  = !isReady">
                        <i class="fas fa-minus"></i>
                    </div>
                </div>

                <!-- Messages -->
                <div 
                @scroll="onScroll" 
                class="messages" 
                id="message-container" 
                x-data="{ messages: @entangle('messages'),
                    scroll: () => { 
                        $el.scrollTo({ top: $el.scrollHeight}); 
                    }  
                }" 
                x-effect="messages.length > 0 && $nextTick(() => { setTimeout(() => $el.scrollTo({ top: $el.scrollHeight, behavior: 'smooth' }), 250); })" 
                x-intersect="scroll()" 
                x-ref="messageContainer">
                    @if(empty($messages))
                        <div class="message bot">
                            <div style="display: flex">
                                <img src="{{ asset('client/assets/images/chatbot-icon.png')}}" class="avatar">
                                <span style="margin-left: 10px">Bot - {{ $msg['time'] ?? now()->format('H:i') }}</span>
                            </div>
                            <div class="message-content bot">
                                Xin chào! Tôi là chatbot hỗ trợ của bạn. Tôi có thể giải đáp các câu hỏi về dịch vụ, cung cấp thông tin, và hỗ trợ bạn 24/7. Hãy bắt đầu bằng cách nhập câu hỏi của bạn ở dưới nhé!
                            </div>
                        </div>
                    @else
                        @foreach ($messages as $msg)
                            <div class="message {{ $msg['type'] }}">
                                @if($msg['type'] == 'bot')
                                <div style="display: flex">
                                    <img src="{{ asset('client/assets/images/chatbot-icon.png')}}" class="avatar">
                                    <span style="margin-left: 10px">Bot - {{ $msg['time'] ?? now()->format('H:i') }}</span>
                                </div>
                                @else
                                    <span style="margin-right: 5px">User - {{ $msg['time'] ?? now()->format('H:i') }}</span>
                                @endif
                                <div class="message-content {{ $msg['type'] }}">
                                    {!! $msg['content'] !!}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <style>
                        .typing-indicator .dot {
                            display: inline-block;
                            width: 6px;
                            height: 6px;
                            margin: 0 2px;
                            background-color: #333;
                            border-radius: 50%;
                            animation: typing 1.5s infinite ease-in-out;
                        }

                        .typing-indicator .dot:nth-child(1) {
                            animation-delay: 0s;
                        }
                        .typing-indicator .dot:nth-child(2) {
                            animation-delay: 0.2s;
                        }
                        .typing-indicator .dot:nth-child(3) {
                            animation-delay: 0.4s;
                        }

                        @keyframes typing {
                            0%, 80%, 100% {
                                transform: scale(0);
                            } 
                            40% {
                                transform: scale(1);
                            }
                        }
                    </style>
                    
                    <!-- Hiển thị "Đang trả lời..." khi chatbot đang trả lời -->
                    @if($isTyping)
                    <div class="message bot typing-indicator">
                        <img src="{{ asset('client/assets/images/chatbot-icon.png')}}" class="avatar">
                        <div class="message-content bot">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                    @endif
                </div>                              

                <!-- Input and Button -->
                <div class="input-container">
                        <input 
                            type="text" 
                            wire:model="prompt" 
                            placeholder="Nhập tin nhắn của bạn..." 
                            maxlength="500" 
                        />
                        <button type="submit" ><i class="fas fa-paper-plane"></i> <!-- Icon gửi --></button>
                        
                        @if(!empty($messages))
                            <!-- Nút Xóa Lịch Sử Tin Nhắn -->
                            <button 
                                type="button" 
                                wire:click="deleteMessages" 
                                style="background: brown"
                            >
                                <i class="fas fa-trash"></i> <!-- Icon xóa -->
                            </button>
                        @endif
                </div>                
            </form>
    </div>

    <script>
    function onScroll() {
        const container = this.$refs.messageContainer;
        const messageElements = container.querySelectorAll('.message');
        
        messageElements.forEach(message => {
            const rect = message.getBoundingClientRect();
            if (
                rect.top >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
            ) {
                message.classList.add('visible');
            } else {
                message.classList.remove('visible');
            }
        });
    }
    </script>
    
</div>
