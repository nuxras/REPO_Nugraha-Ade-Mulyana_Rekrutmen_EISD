<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SiapLapor') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {!! app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']) !!}
        <style>body { font-family: 'Inter', sans-serif; }</style>
    </head>
    <body class="font-sans antialiased text-slate-800">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">

            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-slate-800 font-bold text-2xl tracking-tight">SiapLapor</span>
                    </a>
                </div>

                <!-- Flash Messages -->
                <div class="flex flex-col gap-2 mb-6">
                    @if(session('success'))
                        <div id="flash-success" class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-emerald-800 font-medium text-sm">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="flash-error" class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-red-800 font-medium text-sm">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Form Card -->
                <div class="bg-white px-8 py-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200 rounded-2xl">
                    {{ $slot }}

                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.querySelectorAll('#flash-success, #flash-error, #flash-status').forEach(el => {
                    el.style.transition = 'opacity 0.5s ease-out';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                });
            }, 5000);
        </script>
    </body>
</html>
