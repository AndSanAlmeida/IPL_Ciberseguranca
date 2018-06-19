@component('mail::message')
# Bem-vindo ao IPL-Cibersegurança, {{$user->name}} !!

Ative a sua conta no seguinte botão.

@component('mail::button', ['url' => $url])
Ativar conta
@endcomponent

Obrigado,<br>
IPL-Cibersegurança
@endcomponent