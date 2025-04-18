<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME', 'SIMPRO') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Icons -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

    @livewireStyles

    <!-- Third Parties -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0-alpha.1/dist/trix.css"></link>
    <script src="https://unpkg.com/trix@2.0.0-alpha.1/dist/trix.umd.js"></script>
    <style>
        [data-trix-button-group="file-tools"] {
            display: none !important;
        }
    </style>

</head>
<body class="font-sans antialiased">
<x-banner/>

<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

@stack('modals')

@livewireScripts

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    /* simple notification */
    var notyf = new Notyf({dismissible: true});

    @if (session()->has('success'))
    notyf.success('{{ session('success') }}')
    @endif

    @if (session()->has('error'))
    notyf.error('{{ session('error') }}')
    @endif
</script>


<script>
    /* Simple Alpine Image Viewer */
    document.addEventListener('alpine:init', () => {
        Alpine.data('imageViewer', (src = '') => {
            return {
                imageUrl: src,

                refreshUrl() {
                    this.imageUrl = this.$el.getAttribute("image-url")
                },

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        })
    });

    window.addEventListener('livewire-alert', event => {
        alert(event.detail.message);
    });
    window.addEventListener('reload-all', event => {
        window.location.reload();
    });
    window.addEventListener('redirect', event => {
        window.location.href = event.detail.url;
    });
</script>
</body>
</html>
