<?php include_once "base_start.php"; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?php
                    $hour = date('H');
                    $greeting = ($hour < 12) ? 'Good morning' : (($hour < 18) ? 'Good afternoon' : 'Good evening');
                ?>
                <?= $greeting ?>, <?= h(explode(' ', $user->full_name)[0]); ?>
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Ready to continue your learning journey?
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="/courses.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                Browse New Subjects
            </a>
        </div>
    </div>

    <div class="mb-12">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 flex items-center">
            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            My Enrolled Classes
        </h3>

        <?php if (empty($user_courses)): ?>
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No classes yet</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't registered for any subjects yet.</p>
                <div class="mt-6">
                    <a href="/courses.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Find a Class
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($user_courses as $course):
                     $is_active = ($course['status'] === 'active');

                     // Style Logic (Matches Marketplace)
                     $bg_color = 'bg-blue-600';
                     $icon = '📐';
                     if (stripos($course['course_name'], 'Math') !== false) { $bg_color = 'bg-indigo-600'; $icon = '📐'; }
                     elseif (stripos($course['course_name'], 'English') !== false) { $bg_color = 'bg-green-600'; $icon = '📖'; }
                     elseif (stripos($course['course_name'], 'Physics') !== false) { $bg_color = 'bg-purple-600'; $icon = '⚛️'; }
                     elseif (stripos($course['course_name'], 'Chem') !== false) { $bg_color = 'bg-pink-600'; $icon = '🧪'; }
                ?>
                    <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col transition-all hover:shadow-lg border border-gray-100">
                        <div class="p-5 flex-1">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="h-12 w-12 rounded-md flex items-center justify-center text-2xl <?= $bg_color ?> text-white shadow-sm">
                                        <?= $icon ?>
                                    </span>
                                </div>
                                <div class="ml-4 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Subject
                                        </dt>
                                        <dd>
                                            <div class="text-lg font-bold text-gray-900">
                                                <?= h($course['course_name']); ?>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="mt-4">
                                <?php if($is_active): ?>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-green-600 font-semibold flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                            Active Access
                                        </span>
                                        <span class="text-gray-500">Expires: <?= h(date('M d', strtotime($course['expiry_date']))) ?></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-red-600 font-semibold flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                            Expired
                                        </span>
                                        <span class="text-gray-500">Ended: <?= h(date('M d', strtotime($course['expiry_date']))) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-5 py-3">
                            <?php if ($is_active): ?>
                                <a href="/classroom.php?id=<?= $course['course_id'] ?>" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                    Enter Classroom
                                </a>
                            <?php else: ?>
                                <a href="/register.php?course=<?= $course['course_id'] ?>" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Renew Subscription
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Recommended for You</h3>

        <?php if (empty($all_courses)): ?>
            <p class="text-gray-500">No other courses available.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <?php
                $shown_count = 0;
                foreach ($all_courses as $course):
                    // Skip courses the user already has
                    if(in_array($course->id, array_column($user_courses, 'course_id'))) continue;

                    // Limit to 3 suggestions
                    if($shown_count >= 3) break;
                    $shown_count++;
                ?>
                    <div class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xl">
                                🎓
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="/register.php?course=<?= $course->id ?>" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900"><?= h($course->course_name) ?></p>
                                <p class="text-sm text-gray-500 truncate">₦<?= number_format($course->price) ?></p>
                            </a>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="text-blue-600 text-sm font-medium hover:text-blue-800">Add +</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include __DIR__ . '/base_end.php'; ?>
