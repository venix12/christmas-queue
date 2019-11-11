@if(session('error'))
    @include('components.warning-badge', [
        'icon' => 'warning',
        'warning' => session('error')
    ])
@endif

@if(session('success'))
    @include('components.warning-badge', [
        'icon' => 'check',
        'warning' => session('success')
    ])
@endif