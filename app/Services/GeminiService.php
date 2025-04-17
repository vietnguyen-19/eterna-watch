<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is not configured');
        } else {
            Log::info('Gemini API key loaded successfully');
        }
    }

    public function generateResponse($userMessage, $productData)
    {
        try {
            Log::info('Generating response with Gemini:', [
                'userMessage' => $userMessage,
                'productData' => $productData
            ]);

            $prompt = $this->createPrompt($userMessage, $productData);
            Log::info('Created prompt:', ['prompt' => $prompt]);

            $response = $this->sendRequest($prompt);
            Log::info('Received response from Gemini:', ['response' => $response]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error in generateResponse:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 'Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.';
        }
    }

    protected function createPrompt($userMessage, $productData)
    {
        $basePrompt = <<<EOT
Bạn là chuyên gia tư vấn đồng hồ với nhiều năm kinh nghiệm. Hãy tư vấn dựa trên thông tin sau:

KHÁCH HÀNG HỎI: "{$userMessage}"

DANH SÁCH SẢN PHẨM PHÙ HỢP TỪ CỬA HÀNG:
{$productData}

Yêu cầu:
1. Phân tích nhu cầu của khách hàng (mục đích sử dụng, phong cách, ngân sách)
2. Từ danh sách trên, chọn và giới thiệu 1-2 sản phẩm phù hợp nhất
3. Giải thích chi tiết tại sao những sản phẩm này phù hợp với khách hàng
4. Nêu các ưu điểm nổi bật của sản phẩm (thiết kế, tính năng, giá cả)
5. Đề xuất thêm phụ kiện hoặc dịch vụ đi kèm nếu có
6. Kết thúc bằng cách hỏi xem khách hàng có cần tư vấn thêm không

Quy tắc trả lời:
1. Sử dụng giọng điệu thân thiện, chuyên nghiệp và dễ hiểu
2. Tập trung vào việc giải thích tại sao sản phẩm phù hợp với nhu cầu cụ thể của khách
3. Nếu không có sản phẩm phù hợp, hãy thông báo và đề xuất các lựa chọn thay thế
4. Trả lời ngắn gọn, súc tích nhưng đầy đủ thông tin
5. Sử dụng tiếng Việt có dấu
6. Thêm emoji phù hợp để tăng tính thân thiện

Ví dụ cấu trúc trả lời:
"Chào bạn! 👋

[Phân tích nhu cầu của khách]

Dựa trên yêu cầu của bạn, tôi xin giới thiệu [tên sản phẩm]:
- [Đặc điểm nổi bật]
- [Giá cả]
- [Lý do phù hợp]

[Đề xuất phụ kiện/dịch vụ nếu có]

Bạn có cần tư vấn thêm về sản phẩm này không? 😊"
EOT;

        Log::info('Created prompt:', ['prompt' => $basePrompt]);
        return $basePrompt;
    }

    protected function sendRequest($prompt)
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Gemini API key is not configured');
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post($this->apiEndpoint . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 1024,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_NONE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH',
                            'threshold' => 'BLOCK_NONE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                            'threshold' => 'BLOCK_NONE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                            'threshold' => 'BLOCK_NONE'
                        ]
                    ]
                ]);

            if (!$response->successful()) {
                Log::error('Gemini API Error Response:', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                if ($response->status() === 429) {
                    throw new \Exception('Rate limit exceeded');
                }

                throw new \Exception('API request failed: ' . $response->status());
            }

            $result = $response->json();
            Log::info('Raw API Response:', ['response' => $result]);
            
            if (!isset($result['candidates']) || empty($result['candidates'])) {
                Log::error('No candidates in response', ['response' => $result]);
                throw new \Exception('No candidates in response');
            }

            if (!isset($result['candidates'][0]['content']) || empty($result['candidates'][0]['content'])) {
                Log::error('No content in first candidate', ['response' => $result]);
                throw new \Exception('No content in first candidate');
            }

            if (!isset($result['candidates'][0]['content']['parts']) || empty($result['candidates'][0]['content']['parts'])) {
                Log::error('No parts in content', ['response' => $result]);
                throw new \Exception('No parts in content');
            }

            $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (empty($generatedText)) {
                Log::error('Generated text is empty', ['response' => $result]);
                throw new \Exception('Generated text is empty');
            }

            if (str_contains(strtolower($generatedText), 'error') || 
                str_contains(strtolower($generatedText), 'sorry') || 
                str_contains(strtolower($generatedText), 'cannot')) {
                Log::error('Generated text contains error message', ['text' => $generatedText]);
                throw new \Exception('Generated text contains error message');
            }

            Log::info('Successfully generated response', ['response' => $generatedText]);
            return $generatedText;

        } catch (\Exception $e) {
            Log::error('Error in sendRequest:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
} 