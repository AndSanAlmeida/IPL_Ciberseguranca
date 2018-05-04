@component('mail::message')
Olá, {{ $user->name }}.

Desde já pedimos desculpa pelo incómudo.
Informamos que o estado da sua conta foi alterado.

<b>{{ $mensagem }}</b>

Obrigado,<br>
IPL-Cibersegurança
@endcomponent
