<?php
    if (!isset($error_arr)) $error_arr = array();
    $flash_messages = get_flash_messages();
    $user = get_authenticated_user();
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50 scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <title><?= h($title ?? '') ?> - Nugget Tutorials</title>

        <style>
            [x-cloak] { display: none !important; }
            /* Smooth transitions */
            .nav-link { position: relative; }
            .nav-link::after {
                content: ''; position: absolute; width: 0; height: 2px;
                bottom: -2px; left: 0; background-color: #2563eb;
                transition: width 0.3s;
            }
            .nav-link:hover::after { width: 100%; }
        </style>
    </head>
    <body class="h-full flex flex-col font-[Inter] antialiased text-gray-900">

        <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 transition-all duration-300"
             x-data="{ mobileMenuOpen: false, profileOpen: false, scrolled: false }"
             @scroll.window="scrolled = (window.pageYOffset > 20)">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="flex items-center gap-2 group">
                                <div class="bg-blue-600 text-white p-1.5 rounded-lg shadow-sm group-hover:bg-blue-700 transition-colors">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-gray-900 tracking-tight">
                                    Nugget<span class="text-blue-600">Tutorials</span>
                                </span>
                            </a>
                        </div>

                        <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                            <?php if ($user): ?>
                            <a href="/dashboard.php"
                               class="<?= $_SERVER['REQUEST_URI'] == '/dashboard.php' ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' ?> inline-flex items-center px-1 pt-1 text-sm font-medium nav-link">
                                My Classes
                            </a>
                            <?php endif; ?>

                            <a href="/courses.php"
                               class="<?= strpos($_SERVER['REQUEST_URI'], '/courses.php') !== false ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' ?> inline-flex items-center px-1 pt-1 text-sm font-medium nav-link">
                                Browse Subjects
                            </a>

                            <a href="/about.php"
                               class="<?= strpos($_SERVER['REQUEST_URI'], '/about.php') !== false ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' ?> inline-flex items-center px-1 pt-1 text-sm font-medium nav-link">
                                About Us
                            </a>

                            <a href="/contact.php"
                               class="<?= strpos($_SERVER['REQUEST_URI'], '/contact.php') !== false ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' ?> inline-flex items-center px-1 pt-1 text-sm font-medium nav-link">
                                Contact
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                        <?php if ($user): ?>
                            <div class="ml-3 relative">
                                <div>
                                    <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" type="button"
                                            class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform active:scale-95">
                                        <span class="sr-only">Open user menu</span>
                                        <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold border border-blue-200">
                                            <?= strtoupper(substr($user->full_name, 0, 1)) ?>
                                        </div>
                                    </button>
                                </div>

                                <div x-show="profileOpen" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-2xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">

                                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                                        <p class="text-sm font-medium text-gray-900 truncate"><?= h($user->full_name) ?></p>
                                        <p class="text-xs text-gray-500 truncate"><?= h($user->email) ?></p>
                                    </div>

                                    <div class="py-1">
                                        <a href="/subscription.php" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            My Subscription
                                        </a>
                                        <a href="/settings.php" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Settings
                                        </a>
                                    </div>

                                    <div class="py-1 border-t border-gray-100">
                                        <form action="/logout.php" method="POST" class="block">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                            <button type="submit" class="w-full group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="/login.php" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">Log in</a>
                            <a href="/register.php" class="ml-3 inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-transform transform hover:-translate-y-0.5">
                                Register Free
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="sm:hidden border-t border-gray-200 bg-white" x-show="mobileMenuOpen" x-collapse x-cloak>
                 <div class="pt-2 pb-3 space-y-1 px-2">
                    <?php if ($user): ?>
                        <a href="/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">My Classes</a>
                    <?php endif; ?>

                    <a href="/courses.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Browse Subjects</a>
                    <a href="/about.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">About Us</a>
                    <a href="/contact.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contact</a>

                    <?php if ($user): ?>
                        <a href="/subscription.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">My Subscription</a>
                    <?php endif; ?>
                </div>

                <?php if ($user): ?>
                    <div class="pt-4 pb-4 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    <?= strtoupper(substr($user->full_name, 0, 1)) ?>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800"><?= h($user->full_name) ?></div>
                                <div class="text-sm font-medium text-gray-500"><?= h($user->email) ?></div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <form action="/logout.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Sign out</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                     <div class="pt-4 pb-4 space-y-2 px-4 border-t border-gray-200">
                        <a href="/login.php" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Log in
                        </a>
                        <a href="/register.php" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Register Free
                        </a>
                     </div>
                <?php endif; ?>
            </div>
        </nav>

        <?php if (!empty($flash_messages)): ?>
        <div class="fixed top-20 right-4 z-50 space-y-3 w-full max-w-sm pointer-events-none">
            <?php foreach ($flash_messages as $flash):
                $category = $flash['category'];
                $colors = match($category) {
                    'success' => ['bg' => 'bg-green-50', 'text' => 'text-green-900', 'icon' => 'text-green-500', 'border' => 'border-green-200'],
                    'error' => ['bg' => 'bg-red-50', 'text' => 'text-red-900', 'icon' => 'text-red-500', 'border' => 'border-red-200'],
                    default => ['bg' => 'bg-blue-50', 'text' => 'text-blue-900', 'icon' => 'text-blue-500', 'border' => 'border-blue-200'],
                };
            ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 border <?= $colors['border'] ?>">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 <?= $colors['icon'] ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900"><?= ucfirst($category) ?></p>
                            <p class="mt-1 text-sm text-gray-500"><?= h($flash['message']) ?></p>
                        </div>
                        <div class="ml-4 flex flex-shrink-0">
                            <button @click="show = false" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <main class="flex-1 overflow-y-auto bg-gray-50">
