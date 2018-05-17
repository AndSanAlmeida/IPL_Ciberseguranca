@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Oficina de Cibersegurança IPLeiria
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
		Oficina de Cibersegurança
        @endcomponent
    @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            2018 - Oficina de Cibersegurança IPLeiria
        @endcomponent
    @endslot
@endcomponent
