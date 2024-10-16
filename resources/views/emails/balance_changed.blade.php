<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.email_subject') }}</title>
</head>
<body>
<p>{{ __('messages.greeting', ['name' => $name]) }}</p>

@if($amount > 0)
    <p>{{ __('messages.deposit_message', ['amount' => number_format($amount)]) }}</p>
@else
    <p>{{ __('messages.withdraw_message', ['amount' => number_format(abs($amount))]) }}</p>
@endif

<p>{{ __('messages.thanks') }}</p>
<p>{{ __('messages.bank_system') }}</p>
</body>
</html>
