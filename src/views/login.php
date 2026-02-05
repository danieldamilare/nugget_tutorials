<?php include_once "base_start.php"; ?>

<div class="min-h-screen bg-white flex">
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Welcome back
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    New here?
                    <a href="/register.php" class="font-medium text-blue-600 hover:text-blue-500">
                        Create a free account
                    </a>
                </p>
            </div>

            <div class="mt-8">
                <?php if (isset($error_arr['general'])): ?>
                    <div class="rounded-md bg-red-50 p-4 mb-6 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    <?= h($error_arr['general']) ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <form action="/login.php" method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       value="<?= h($_POST['email'] ?? '') ?>"
                                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?= isset($error_arr['email']) ? 'border-red-500' : '' ?>">
                            </div>
                            <?php if (isset($error_arr['email'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?= h($error_arr['email']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?= isset($error_arr['password']) ? 'border-red-500' : '' ?>">
                            </div>
                            <?php if (isset($error_arr['password'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?= h($error_arr['password']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
                            </div>

                            <div class="text-sm">
                                <a href="#" class="font-medium text-blue-600 hover:text-blue-500"> Forgot your password? </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:block relative w-0 flex-1">
        <img class="absolute inset-0 h-full w-full object-cover" src="/assets/img/hero.avif" alt="Student learning">
        <div class="absolute inset-0 bg-blue-900 opacity-40 mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 p-20 text-white">
            <h3 class="text-2xl font-bold">"Education is the passport to the future."</h3>
            <p class="mt-4 font-medium text-blue-200">Continue your journey today.</p>
        </div>
    </div>
</div>

<?php include_once "base_end.php"; ?>
