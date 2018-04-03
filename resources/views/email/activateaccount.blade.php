@component('mail::message')
# Bem-vindo ao Portal de Cibersegurança, {{$user->name}} !!

Ative a sua conta no seguinte botão.

@component('mail::button', ['url' => $url])
Ativar conta
@endcomponent

Obrigado,<br>
Oficina de Cibersegurança
@endcomponent