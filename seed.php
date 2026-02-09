<?php
require_once __DIR__ . '/db.php';

$courses = [
    ['Maths', 'KS2', 25.00, 'Foundational numeracy, fractions, and SATs preparation.'],
    ['Maths', 'GCSE', 35.00, 'Algebra, geometry, and exam techniques for AQA/Edexcel.'],
    ['Maths', 'A-Level', 45.00, 'Calculus, trigonometry, and advanced mechanics.'],
    ['Maths', 'SATs', 45.00, 'Comprehensive  Maths SATs preparation'],

    ['English', 'KS2', 25.00, 'Creative writing, grammar, and reading comprehension.'],
    ['English', 'GCSE', 35.00, 'Analysis of Macbeth, An Inspector Calls, and poetry.'],
    ['English', 'A-Level', 45.00, 'Critical analysis of English Literature and linguistics.'],
    ['English', 'SATs', 45.00, 'Critical analysis of English Literature and linguistics.'],

    ['Physics', 'GCSE', 38.00, 'Energy, forces, and electricity fundamentals.'],
    ['Physics', 'A-Level', 50.00, 'Nuclear physics, oscillations, and astrophysics.'],
    ['Chemistry', 'GCSE', 38.00, 'Atomic structure, bonding, and organic chemistry.'],
    ['Chemistry', 'A-Level', 50.00, 'Thermodynamics, kinetics, and transition metals.'],
    ['Biology', 'GCSE', 35.00, 'Cell biology, infection, and bioenergetics.'],
    ['Biology', 'A-Level', 45.00, 'Biological molecules, genetics, and ecosystems.'],

    ['Further Maths', 'A-Level', 55.00, 'Complex numbers, matrices, and hyperbolic functions.'],
];

$db = get_db();

// Use a transaction for speed and integrity
$db->beginTransaction();

try {
    $stmt = $db->prepare("INSERT OR IGNORE INTO courses (course_name, level, price, description) VALUES (?, ?, ?, ?)");

    foreach ($courses as $course) {
        $stmt->execute($course);
    }

    $db->commit();
    echo "Success: 15 professional courses seeded/updated.";
} catch (Exception $e) {
    $db->rollBack();
    die("Seeding failed: " . $e->getMessage());
}
?>
