@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
IPLeiria | Cibersegurança
@endcomponent
@endslot
    
# Bem-vindo ao IPLeiria | Cibersegurança, {{$user->name}} !!

Ative a sua conta no seguinte botão.

@component('mail::button', ['url' => $url])
Ativar conta
@endcomponent

{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
Obrigado,<br>
Administração do IPLeiria | Cibersegurança
@endcomponent
@endslot


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{date("Y")}} IPLeiria | Cibersegurança
@endcomponent
@endslot
@endcomponent
