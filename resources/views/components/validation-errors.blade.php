@props(['class' => ''])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 alert alert-danger ' . $class]) }}>
        <div class="fw-bold">Whoops! Something went wrong.</div>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
