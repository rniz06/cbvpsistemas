<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('img/cbvp-logo-png.webp')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ $title ?? 'CBVP Asamblea' }}</title>
</head>

<body class="flex flex-col min-h-screen bg-yellow-400">
    <header class="bg-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('img/cbvp-logo.webp') }}" alt="CBVP Logo" class="h-8 mr-4">
                <a href="{{url('/')}}" class="text-gray-800 font-bold text-xl">CBVP | Asamblea</a>
            </div>
            <nav>
                <ul class="flex space-x-4">
                    
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer fijo al fondo -->
    <footer class="bg-gray-900 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?php echo date('Y'); ?> Departamento de TI | CBVP</p>
        </div>
    </footer>
</body>

</html>