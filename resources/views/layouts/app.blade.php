<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESPRO - Application de Gestion de Projets</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0 border-r border-slate-800 flex flex-col justify-between p-4">
            <div>
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 px-2 py-4 mb-6 border-b border-slate-800">
                    <img src="/logo.jpg" alt="GESPRO Logo" class="h-9 w-auto rounded-lg bg-white/10 p-1" />
                    <div>
                        <span class="text-xl font-black text-white tracking-tight font-display">GESPRO</span>
                        <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-widest">YA CONSULTING</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Tableau de bord</span>
                    </a>

                    <a href="{{ route('projets.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('projets.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Projets</span>
                    </a>

                    <a href="{{ route('statistiques.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('statistiques.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Statistiques</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Rapports mensuels</span>
                    </a>

                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Utilisateurs</span>
                    </a>

                    <a href="{{ route('action-logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('action-logs.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Journal d'audit</span>
                    </a>
                    @endif

                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <span>Paramètres</span>
                    </a>
                </nav>
            </div>

            <!-- User Info & Logout -->
            <div class="border-t border-slate-800 pt-4 mt-6">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div>
                        <span class="block text-sm font-bold text-white truncate max-w-[140px]">{{ auth()->user()->name }}</span>
                        <span class="block text-[10px] text-slate-400 capitalize font-medium">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-rose-600 text-slate-300 hover:text-white rounded-xl text-xs font-bold transition-all">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header Bar -->
            <header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-black text-slate-900 dark:text-white font-display">
                    @yield('header', 'GESPRO')
                </h1>

                <!-- Dark Mode Toggle -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleDarkMode()" id="theme-toggle"
                        class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all flex items-center justify-center shadow-sm"
                        title="Changer d'apparence">
                        <!-- Icône Soleil (mode clair) -->
                        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <!-- Icône Lune (mode sombre) -->
                        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600 dark:hidden block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-6 md:p-8 flex-1">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950/50 dark:border-emerald-800 dark:text-emerald-300 rounded-2xl text-sm font-semibold flex items-center gap-2">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 dark:bg-rose-950/50 dark:border-rose-800 dark:text-rose-300 rounded-2xl text-sm font-semibold flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>
