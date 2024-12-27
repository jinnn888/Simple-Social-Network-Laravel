<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- fas fa --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <div class='flex flex-col md:flex-row border border-2 justify-center p-4'>
            {{-- Sidebar ( Profile Card) --}}
            <a href='{{ route('users.profile', auth()->user()->id ) }}' class='p-12 flex flex-col space-y-2  items-center bg-white h-fit rounded mt-4 shadow-sm'>
                <img src="{{ Storage::url( Auth::user()->image) }}" class='rounded-full overflow-hidden w-[150px] h-[150px] object-cover '>
                <h2 class='text-lg font-semibold'>{{ auth()->user()->name }}</h2>
                <span class='text-md'>{{ auth()->user()->email }}</span>

                    {{-- Followers/Following/Post Count --}}
                    <div class='flex flex-row text-xl'>
                        <span>Followers {{ auth()->user()->followers()->count() }} |</span>
                        <span>Following {{ auth()->user()->followings()->count() }} |</span>
                        <span>Posts {{ auth()->user()->posts()->count() }}</span>
                    </div>
 
            </a>

                <main class='flex-grow'>
                    {{ $slot }}
                </main>
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
    </html>
