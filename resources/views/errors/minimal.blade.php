<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="relative h-screen overflow-hidden bg-indigo-900">
        <img src="https://www.tailwind-kit.com/images/landscape/8.svg" class="absolute object-cover w-full h-full" />
        <div class="absolute inset-0 bg-black opacity-25">
        </div>
        <div class="container relative z-10 flex items-center px-6 py-32 mx-auto md:px-12 xl:py-40">
            <div class="relative z-10 flex flex-col items-center w-full font-mono">
                <h1 class="mt-4 text-5xl font-extrabold leading-tight text-center text-white">
                    You&#x27;re alone here
                </h1>
                <p class="mt-4 text-xl text-center text-white">
                    @yield('message')
                </p>
                <p class="mt-4 text-xl text-center text-white">
                    <a href="/" class="text-indigo-300 hover:text-indigo-200">
                        Go back to the homepage
                    </a>
                </p>
                <p class="mt-20 font-extrabold text-white text-8xl animate-bounce">
                    @yield('code')
                </p>
            </div>
        </div>
    </div>
</body>

</html>
