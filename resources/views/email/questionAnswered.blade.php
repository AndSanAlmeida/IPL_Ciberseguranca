@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => env('APP_URL')])
            IPLeiria | Cibersegurança
        @endcomponent
    @endslot

    {{-- Body --}}
    Olá, {{ $user->name }}.

	{{ $mensagem }}
	{{ $questionText}}
	{{ $answerText}}

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
