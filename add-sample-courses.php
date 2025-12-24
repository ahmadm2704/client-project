<?php
require 'autoload.php';
require 'config.php';

try {
    $courses = [
        ['Computing', 'BSc Computer Science', 'BSc', 3, 'Learn the fundamentals of computer science including algorithms, data structures, and software engineering principles.', 1, 1],
        ['Computing', 'MSc Advanced Computing', 'MSc', 2, 'Advanced computing course covering machine learning, cloud computing, and distributed systems.', 1, 1],
        ['Computing', 'BSc Software Engineering', 'BSc', 3, 'Focus on software development methodologies, project management, and real-world application development.', 0, 1],
        ['Computing', 'MA Web Development', 'MA', 2, 'Master modern web technologies including React, Node.js, and full-stack development practices.', 1, 1],
        ['Computing', 'BSc Information Technology', 'BSc', 3, 'Comprehensive IT course covering networking, databases, security, and IT infrastructure.', 1, 1],
        ['Computing', 'MSc Data Science', 'MSc', 2, 'Deep dive into data science, machine learning, and big data analytics.', 0, 1],
        ['Computing', 'BSc Cybersecurity', 'BSc', 3, 'Learn cybersecurity principles, ethical hacking, and information security management.', 1, 1],
        ['Computing', 'Diploma IT Support', 'Diploma', 2, 'Practical IT support and helpdesk fundamentals for career starters.', 1, 1],
        ['Computing', 'BSc Game Development', 'BSc', 3, 'Create games using modern game engines and learn game design principles.', 0, 1],
        ['Computing', 'MSc AI Engineering', 'MSc', 2, 'Advanced artificial intelligence and machine learning engineering.', 1, 1],
        ['Computing', 'BSc Mobile App Development', 'BSc', 3, 'Develop mobile applications for iOS and Android platforms.', 1, 1],
        ['Computing', 'Certificate Cloud Computing', 'Certificate', 1, 'Introduction to AWS, Azure, and Google Cloud platforms.', 1, 1],
        ['Computing', 'BSc Networking', 'BSc', 3, 'Computer networks, routing, switching, and network administration.', 0, 1],
        ['Computing', 'MA IT Management', 'MA', 2, 'IT strategy, project management, and enterprise IT systems.', 1, 1],
        ['Computing', 'BSc Database Systems', 'BSc', 3, 'Database design, SQL, and advanced database management systems.', 1, 1],
    ];

    $inserted = 0;

    foreach ($courses as $course) {
        list($subjectName, $title, $type, $duration, $description, $partTime, $userId) = $course;

        $stmt = \App\Models\Database::query('SELECT id FROM subject_areas WHERE name = ?', [$subjectName]);
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subject) {
            $sql = 'INSERT INTO courses (title, subject_area_id, type, duration_years, description, part_time_available, created_by, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW())';
            $result = \App\Models\Database::execute($sql, [
                $title,
                $subject['id'],
                $type,
                $duration,
                $description,
                $partTime,
                $userId
            ]);
            $inserted++;
        }
    }

    echo "Successfully inserted $inserted sample courses for pagination testing!\n";
    echo "Visit http://localhost/subject-area/1 to see pagination in action.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
