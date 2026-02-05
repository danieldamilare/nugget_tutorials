<?php include_once "base_start.php"; ?>

<div class="bg-blue-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                Find Your Subject
            </h1>
            <p class="mt-4 text-xl text-blue-200">
                Choose from our list of expert-led courses for A-Level, GCSE, and Juniors.
            </p>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (empty($courses)): ?>
            <div class="text-center py-20">
                <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600 mb-4">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No courses available yet</h3>
                <p class="mt-1 text-gray-500">Check back soon as we add new subjects.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($courses as $course):
                    // Dynamic Colors based on Subject Name
                    $bg_color = 'bg-blue-600';
                    $icon = '📐'; // Default

                    if (stripos($course->course_name, 'Math') !== false) {
                        $bg_color = 'bg-indigo-600';
                        $icon = '📐';
                    } elseif (stripos($course->course_name, 'English') !== false) {
                        $bg_color = 'bg-green-600';
                        $icon = '📖';
                    } elseif (stripos($course->course_name, 'Physics') !== false) {
                        $bg_color = 'bg-purple-600';
                        $icon = '⚛️';
                    } elseif (stripos($course->course_name, 'Chem') !== false) {
                        $bg_color = 'bg-pink-600';
                        $icon = '🧪';
                    }
                ?>

                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="h-24 <?= $bg_color ?> flex items-center justify-center">
                        <span class="text-4xl filter drop-shadow-lg transform hover:scale-110 transition duration-300 cursor-default">
                            <?= $icon ?>
                        </span>
                    </div>

                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Live Class
                                </span>
                                <span class="text-gray-400 text-sm">Online</span>
                            </div>

                            <a href="/register.php?course=<?= $course->id ?>" class="block mt-4">
                                <p class="text-xl font-bold text-gray-900"><?= h($course->course_name) ?></p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-2">
                                    Master <?= h($course->course_name) ?> with step-by-step video lessons and direct access to expert tutors.
                                </p>
                            </a>
                        </div>

                        <div class="mt-6 border-t border-gray-100 pt-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-baseline">
                                    <span class="text-2xl font-extrabold text-gray-900">₦<?= number_format($course->price) ?></span>
                                    <span class="ml-1 text-sm text-gray-500">/mo</span>
                                </div>
                                <a href="/register.php?course=<?= $course->id ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                    Start Learning
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            <span class="block">Ready to boost your grades?</span>
            <span class="block text-blue-600">Join Nugget Tutorials today.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-md shadow">
                <a href="/register.php" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Create Free Account
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once "base_end.php"; ?>
