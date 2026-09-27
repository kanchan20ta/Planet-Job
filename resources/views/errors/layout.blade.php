<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') - Planet Job Portal</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/3.4.1/tailwind.min.js"></script>
</head>
<body class="font-sans bg-gray-50 text-gray-800 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <p class="text-6xl font-extrabold text-brand-600">@yield('code')</p>
        <h1 class="text-xl font-bold text-gray-900 mt-4">@yield('heading')</h1>
        <p class="text-gray-500 mt-2 max-w-sm mx-auto">@yield('message')</p>
        <a href="/" class="inline-block mt-6 bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-brand-700">
            Back to Home
        </a>
    </div>
</body>
</html>
