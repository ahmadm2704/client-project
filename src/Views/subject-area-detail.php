<!doctype html>
<html>
	<head>
		<title><?php echo htmlspecialchars($subjectArea['name']); ?> - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			main {
				display: flex;
				justify-content: center;
				padding: 40px 20px;
			}
			.container {
				width: 100%;
				max-width: 900px;
			}
			.subject-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 30px;
			}
			.subject-header h1 {
				margin: 0;
				color: #333;
				font-size: 32px;
				font-weight: 700;
			}
			.courses-section {
				background: white;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.08);
			}
			.courses-section h2 {
				color: #333;
				margin: 0 0 25px 0;
				font-size: 20px;
				font-weight: 700;
			}
			.course-item {
				padding: 20px;
				border: 1px solid #eee;
				border-radius: 4px;
				margin-bottom: 15px;
				background: #fafafa;
				transition: all 0.3s;
				display: flex;
				justify-content: space-between;
				align-items: flex-start;
				gap: 20px;
			}
			.course-item:hover {
				background: white;
				border-color: #1976d2;
				box-shadow: 0 2px 8px rgba(0,0,0,0.1);
			}
			.course-content {
				flex: 1;
			}
			.course-item h3 {
				margin: 0 0 8px 0;
				color: #333;
				font-size: 18px;
				font-weight: 700;
			}
			.course-meta {
				display: flex;
				gap: 12px;
				margin-bottom: 10px;
				font-size: 12px;
				color: #999;
				flex-wrap: wrap;
			}
			.course-meta span {
				background: #e8f4f8;
				padding: 3px 8px;
				border-radius: 3px;
				color: #0288d1;
			}
			.course-item p {
				margin: 0;
				color: #666;
				font-size: 14px;
				line-height: 1.6;
			}
			.course-link {
				display: inline-block;
				margin-top: 12px;
				padding: 8px 16px;
				background: #1976d2;
				color: white;
				text-decoration: none;
				border-radius: 4px;
				font-size: 13px;
				font-weight: 700;
				transition: background 0.3s;
				white-space: nowrap;
			}
			.course-link:hover {
				background: #1565c0;
			}
			.empty-state {
				text-align: center;
				padding: 40px;
				color: #999;
			}
			.empty-state p {
				font-size: 16px;
				margin: 0;
			}
			.btn {
				display: inline-block;
				padding: 12px 24px;
				background: #1976d2;
				color: white;
				text-decoration: none;
				border-radius: 4px;
				font-weight: 700;
				transition: background 0.3s;
			}
			.btn:hover {
				background: #1565c0;
			}
		</style>
	</head>

	<body>
		<header>
			<img src="/logo.jpg" alt="logo" />
			<ul>
                <li><a href="/">Home</a></li>
				<?php \App\Helpers\HeaderHelper::renderSubjectAreasMenu(); ?>
                <li><a href="/enquiry">Make an enquiry</a></li>
			</ul>
		</header>
		
		<section></section>
		
		<main>
			<div class="container">
				<div class="subject-header">
					<h1><?php echo htmlspecialchars($subjectArea['name']); ?></h1>
					<a href="/" class="btn">Back Home</a>
				</div>

				<div class="courses-section">
					<h2>Available Courses</h2>
					
					<?php if (is_array($courses) && count($courses) > 0): ?>
						<?php foreach ($courses as $course): ?>
							<div class="course-item">
								<div class="course-content">
									<h3><?php echo htmlspecialchars($course['title']); ?></h3>
									<div class="course-meta">
										<span><?php echo htmlspecialchars($course['type']); ?></span>
										<span><?php echo $course['duration_years']; ?> year<?php echo $course['duration_years'] > 1 ? 's' : ''; ?></span>
										<?php if ($course['part_time_available']): ?>
											<span>Part-time available</span>
										<?php endif; ?>
									</div>
									<p><?php echo htmlspecialchars(substr($course['description'], 0, 150)); ?><?php echo strlen($course['description']) > 150 ? '...' : ''; ?></p>
									<a href="/course/<?php echo $course['id']; ?>" class="course-link">View Course →</a>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="empty-state">
							<p>No courses available in this subject area yet.</p>
						</div>
					<?php endif; ?>

					<!-- Pagination -->
					<?php if (isset($totalPages) && $totalPages > 1): ?>
						<div style="display: flex; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;">
							<!-- Previous Button -->
							<?php if ($currentPage > 1): ?>
								<a href="?page=<?php echo $currentPage - 1; ?>" style="padding: 8px 12px; background: #1976d2; color: white; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;" onmouseover="this.style.background='#1565c0'" onmouseout="this.style.background='#1976d2'">← Previous</a>
							<?php endif; ?>

							<!-- Page Numbers -->
							<?php
								$startPage = max(1, $currentPage - 2);
								$endPage = min($totalPages, $currentPage + 2);

								if ($startPage > 1) {
									echo '<a href="?page=1" style="padding: 8px 12px; background: #f0f0f0; text-decoration: none; border-radius: 4px; font-weight: 600;">1</a>';
									if ($startPage > 2) {
										echo '<span style="padding: 8px 12px; color: #999;">...</span>';
									}
								}

								for ($i = $startPage; $i <= $endPage; $i++) {
									if ($i == $currentPage) {
										echo '<span style="padding: 8px 12px; background: #1976d2; color: white; border-radius: 4px; font-weight: 600;">' . $i . '</span>';
									} else {
										echo '<a href="?page=' . $i . '" style="padding: 8px 12px; background: #f0f0f0; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;" onmouseover="this.style.background=\'#e0e0e0\'" onmouseout="this.style.background=\'#f0f0f0\'">' . $i . '</a>';
									}
								}

								if ($endPage < $totalPages) {
									if ($endPage < $totalPages - 1) {
										echo '<span style="padding: 8px 12px; color: #999;">...</span>';
									}
									echo '<a href="?page=' . $totalPages . '" style="padding: 8px 12px; background: #f0f0f0; text-decoration: none; border-radius: 4px; font-weight: 600;">' . $totalPages . '</a>';
								}
							?>

							<!-- Next Button -->
							<?php if ($currentPage < $totalPages): ?>
								<a href="?page=<?php echo $currentPage + 1; ?>" style="padding: 8px 12px; background: #1976d2; color: white; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;" onmouseover="this.style.background='#1565c0'" onmouseout="this.style.background='#1976d2'">Next →</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</main>

		<aside>
            <p><?php echo htmlspecialchars($subjectArea['name']); ?> courses are designed to provide comprehensive education in this field.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

