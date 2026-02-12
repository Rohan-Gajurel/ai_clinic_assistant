<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUa1zY4a1TI2p6jxnob+G2txaI5iQ9fX1EWNSaFw5pGyu5YdK7arNbE1jAo6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3mgPxhU8Cw7K8YfRFAEn8I1k1y" crossorigin="anonymous"></script>

<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</x-layouts::app.sidebar>
