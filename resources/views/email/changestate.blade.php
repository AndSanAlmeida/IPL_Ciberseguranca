@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => env('APP_URL')])
            IPLeiria | Cibersegurança
        @endcomponent
    @endslot
    
    Olá, {{ $user->name }}.

	Desde já pedimos desculpa pelo incómudo.
	Informamos que o estado da sua conta foi alterado.

	{{ $mensagem }}

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