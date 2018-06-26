@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
IPLeiria | Cibersegurança
@endcomponent
@endslot

{{-- Body --}}
Definir nova palavra passe.
Clique no seguinte link para definir uma nova password

@component('mail::button', ['url' => url("/auth/#/password/reset/$token")])
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
