<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
    <h1>{{ $greeting }}</h1>
@else
    @if ($level === 'error')
        <h1>@lang('Rất tiếc!')</h1>
    @else
        <h1>@lang('Chào bạn!')</h1>
    @endif
@endif

{{-- Intro Lines --}}
<p>@lang('Vui lòng nhấn nút dưới đây để xác thực địa chỉ email của bạn.')</p>

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
    {{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
<p>@lang('Nếu bạn không tạo tài khoản này, bạn có thể bỏ qua email này và không cần làm gì thêm.')</p>


{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Nếu bạn gặp khó khăn khi nhấn vào nút \":actionText\", hãy sao chép và dán URL dưới đây\n". 
    'vào trình duyệt của bạn:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
