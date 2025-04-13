@extends('client.layouts.master')

@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-3"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="chatbot-container shadow-lg mt-2">
                    <div class="chat-header d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="fas fa-robot me-2"></i>Tư Vấn Trực Tuyến
                        </h4>
                        <button id="clearChat" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-trash-alt me-1"></i>Xóa lịch sử
                        </button>
                    </div>
                    <div class="chat-messages" id="chatMessages">
                        <!-- Tin nhắn chào mừng -->
                        <div class="message bot-message">
                            <div class="message-content">
                                Xin chào! Tôi là trợ lý ảo của Eterna Watch. Tôi có thể giúp gì cho bạn?
                            </div>
                            <div class="message-time">Hôm nay</div>
                        </div>
                    </div>
                    <div class="chat-input">
                        <form id="chatForm" class="d-flex align-items-center">
                            <input type="text" id="userMessage" class="form-control" placeholder="Nhập tin nhắn của bạn..." maxlength="500" required>
                            <button type="submit" class="btn btn-primary ms-2" id="sendButton">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                        <div class="text-end mt-1">
                            <small class="text-muted" id="charCount">0/500</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 pb-xl-5"></div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chatForm');
            const userMessage = document.getElementById('userMessage');
            const chatMessages = document.getElementById('chatMessages');
            const sendButton = document.getElementById('sendButton');
            const clearChat = document.getElementById('clearChat');
            const charCount = document.getElementById('charCount');

            // Hàm thêm tin nhắn vào khung chat
            function addMessage(message, isUser = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
                
                const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                messageDiv.innerHTML = `
                    <div class="message-content">${message}</div>
                    <div class="message-time">${time}</div>
                `;
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Hàm hiển thị hiệu ứng đang gõ
            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.className = 'message bot-message typing-indicator';
                typingDiv.innerHTML = `
                    <div class="message-content">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                `;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                return typingDiv;
            }

            // Hàm xóa hiệu ứng đang gõ
            function removeTypingIndicator(indicator) {
                if (indicator) {
                    indicator.remove();
                }
            }

            // Xử lý khi gửi tin nhắn
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const message = userMessage.value.trim();
                if (!message) return;

                // Hiển thị tin nhắn của người dùng
                addMessage(message, true);
                userMessage.value = '';
                charCount.textContent = '0/500';

                // Vô hiệu hóa nút gửi và hiển thị loading
                sendButton.disabled = true;
                sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                // Hiển thị hiệu ứng đang gõ
                const typingIndicator = showTypingIndicator();

                try {
                    // Gửi tin nhắn đến server
                    const response = await fetch('{{ route("client.chatbot.chat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ message })
                    });

                    const data = await response.json();
                    
                    // Xóa hiệu ứng đang gõ
                    removeTypingIndicator(typingIndicator);
                    
                    // Hiển thị phản hồi từ chatbot
                    if (data.status === 'success') {
                        addMessage(data.message);
                    } else {
                        addMessage('Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    removeTypingIndicator(typingIndicator);
                    addMessage('Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.');
                } finally {
                    // Kích hoạt lại nút gửi
                    sendButton.disabled = false;
                    sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
                }
            });

            // Xử lý sự kiện xóa lịch sử chat
            clearChat.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa lịch sử chat?')) {
                    chatMessages.innerHTML = `
                        <div class="message bot-message">
                            <div class="message-content">
                                Xin chào! Tôi là trợ lý ảo của Eterna Watch. Tôi có thể giúp gì cho bạn?
                            </div>
                            <div class="message-time">Hôm nay</div>
                        </div>
                    `;
                }
            });

            // Xử lý đếm ký tự
            userMessage.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = `${length}/500`;
                if (length > 500) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
        });
    </script>
@endsection

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .chatbot-container {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            background: #bd1c1c;
            color: white;
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
            clear: both;
            opacity: 0;
            transform: translateY(20px);
            animation: messageAppear 0.3s ease forwards;
        }

        @keyframes messageAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bot-message {
            float: left;
        }

        .user-message {
            float: right;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 15px;
            margin-bottom: 5px;
            word-wrap: break-word;
        }

        .bot-message .message-content {
            background: #e9ecef;
            color: #212529;
        }

        .user-message .message-content {
            background: #bd1c1c;
            color: white;
        }

        .message-time {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
        }

        .chat-input {
            padding: 20px;
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .chat-input input {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 20px;
        }

        .chat-input button {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #bd1c1c;
            border: none;
        }

        .chat-input button:hover {
            background: #cf1818;
            transform: translateY(-2px);
        }

        .chat-input button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Custom Scrollbar */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #bd1c1c;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #cf1818;
        }

        /* Typing Indicator */
        .typing-indicator .message-content {
            background: #e9ecef;
            padding: 10px 16px;
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: #6c757d;
            display: inline-block;
            border-radius: 50%;
            margin-right: 3px;
            animation: typing 1s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
@endsection
