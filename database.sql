CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('superadmin', 'staff') NOT NULL DEFAULT 'staff',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_username (username),
  INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `subject_areas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NOT NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_name (name),
  INDEX idx_created_by (created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `subject_area_id` INT NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `duration_years` INT NOT NULL,
  `description` LONGTEXT NOT NULL,
  `part_time_available` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NOT NULL,
  FOREIGN KEY (subject_area_id) REFERENCES subject_areas(id) ON DELETE CASCADE,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_subject_area_id (subject_area_id),
  INDEX idx_type (type),
  INDEX idx_created_by (created_by),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `modules` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `description` LONGTEXT NOT NULL,
  INDEX idx_code (code),
  INDEX idx_title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `course_modules` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `module_id` INT NOT NULL,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
  UNIQUE KEY unique_course_module (course_id, module_id),
  INDEX idx_course_id (course_id),
  INDEX idx_module_id (module_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `phone` VARCHAR(20),
  `course_id` INT NOT NULL,
  `message` LONGTEXT NOT NULL,
  `status` ENUM('new', 'responded', 'closed') DEFAULT 'new',
  `responded_by` INT,
  `responded_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  FOREIGN KEY (responded_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_course_id (course_id),
  INDEX idx_status (status),
  INDEX idx_email (email),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`username`, `password`, `role`) 
VALUES ('superadmin', '$2y$10$DH37BisvFqbhUe4h434J0urzabYugWSjzbjgwqEWABtns52eeC84e', 'superadmin');

INSERT INTO `modules` (`code`, `title`, `description`) VALUES
('CS101', 'Introduction to Computer Science', 'Fundamental concepts of computer science including algorithms, data structures, and computational thinking.'),
('CS102', 'Web Development Basics', 'Learn HTML, CSS, JavaScript, and basic web development principles.'),
('CS103', 'Database Design', 'Relational databases, SQL, normalization, and database optimization techniques.'),
('CS104', 'Object-Oriented Programming', 'OOP principles, design patterns, and implementation in popular languages.'),
('CS105', 'Advanced Python', 'Advanced Python programming including decorators, generators, and metaprogramming.'),
('MATH101', 'Calculus I', 'Limits, derivatives, and integration with applications.'),
('MATH102', 'Linear Algebra', 'Vectors, matrices, eigenvalues, and linear transformations.'),
('STAT101', 'Probability and Statistics', 'Probability theory, distributions, hypothesis testing, and statistical inference.'),
('ML101', 'Machine Learning Fundamentals', 'Supervised learning, unsupervised learning, and practical ML algorithms.'),
('DS101', 'Data Science Essentials', 'Data manipulation, exploratory data analysis, and visualization techniques.'),
('WEB201', 'Full Stack Web Development', 'Building complete web applications with frontend and backend technologies.'),
('MOBILE101', 'Mobile App Development', 'Developing mobile applications for iOS and Android platforms.'),
('NET101', 'Computer Networks', 'Network protocols, TCP/IP, routing, and network security fundamentals.'),
('SEC101', 'Cybersecurity Basics', 'Security principles, cryptography, and secure system design.'),
('AI101', 'Artificial Intelligence', 'AI concepts, knowledge representation, and intelligent systems.'),
('CLOUD101', 'Cloud Computing', 'Cloud platforms, virtualization, containers, and serverless computing.');
