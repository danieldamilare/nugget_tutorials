<?php include_once "base_start.php"; ?>

<div class="min-h-screen bg-gray-50">
    <div class="bg-blue-900 pb-32">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-blue-200 tracking-wide uppercase">Contact Us</h2>
                <p class="mt-1 text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl">Let's start a conversation.</p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-blue-100">
                    Have questions about our A-Level, GCSE, or KS1/KS2 courses? We're here to help you succeed.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 pb-16">
        <div class="relative bg-white shadow-2xl rounded-2xl overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                <div class="relative overflow-hidden bg-blue-700 py-10 px-6 sm:px-10 xl:p-12">
                    <div class="absolute inset-0 pointer-events-none sm:hidden lg:block" aria-hidden="true">
                        <svg class="absolute -right-40 -bottom-40 h-full w-full text-blue-800 opacity-50 transform -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-medium text-blue-100">Contact Information</h3>
                    <p class="mt-6 text-base text-blue-50 max-w-sm">
                        Prefer to email us directly? Reach out through any of these channels.
                    </p>

                    <dl class="mt-8 space-y-6">
                        <dt><span class="sr-only">Email</span></dt>
                        <dd class="flex text-base text-blue-50">
                            <svg class="flex-shrink-0 w-6 h-6 text-blue-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="ml-3">
                                <a href="mailto:info@nuggetstutorials.com" class="hover:text-white transition">info@nuggetstutorials.com</a>
                                <br>
                                <a href="mailto:nuggetstutorials@gmail.com" class="hover:text-white transition">nuggetstutorials@gmail.com</a>
                            </span>
                        </dd>

                        <dt><span class="sr-only">Social</span></dt>
                        <dd class="flex text-base text-blue-50">
                             <svg class="flex-shrink-0 w-6 h-6 text-blue-200" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3">
                                Facebook: <span class="font-bold">Nuggets Tutorials</span>
                            </span>
                        </dd>
                    </dl>
                </div>

                <div class="py-10 px-6 sm:px-10 lg:col-span-1 xl:p-12">
                    <h3 class="text-lg font-medium text-gray-900">Send us a message</h3>

                    <?php if (isset($error_arr['general'])): ?>
                        <div class="mt-4 rounded-md bg-red-50 p-4 border border-red-200">
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

                    <form action="/send_contact.php" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" required
                                       class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-900">Message</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required
                                          class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition hover:-translate-y-0.5">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "base_end.php"; ?>
