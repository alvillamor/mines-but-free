<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
        <style>
            * {
                font-family: 'Montserrat', sans-serif;
            }  

            #hits::-webkit-scrollbar-track
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
                background-color: #000;
                border-radius: 5px;
            }

            #hits::-webkit-scrollbar
            {
                height: 6px;
                background-color: #000;
            }

            #hits::-webkit-scrollbar-thumb
            {
                border-radius: 5px;
                background-color: #FFF;
                background-image: -webkit-gradient(linear,
                                                40% 0%,
                                                75% 84%,
                                                from(#0ea5e9),
                                                to(#1d4ed8),
                                                color-stop(.6,#1d4ed8))
            }

            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* Firefox */
            input[type=number] {
            -moz-appearance: textfield;
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-white antialiased bg-gray-900 min-h-screen flex items-center justify-center">
            <div class="py-2">
                <div class="max-w-7xl mx-auto px-10 lg:px-8">            
                    {{ $slot }}
                </div>
            </div>
            
        </div>
        @livewireScripts        
    </body>
</html>
