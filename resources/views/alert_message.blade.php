@if( session('flashSuccess') )
    <x-alert class="success" message="{{ session('flashSuccess') }}"></x-alert>
@elseif( session('flashWarning') )
    <x-alert class="warning" message="{{ session('flashWarning') }}"></x-alert>
@elseif( session('flashError') )
    <x-alert class="danger" message="{{ session('flashError') }}"></x-alert>
@endif