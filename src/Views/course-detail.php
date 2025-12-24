<!doctype html>
<html>
	<head>
		<title><?php echo isset($course) ? htmlspecialchars($course['title']) : 'Course'; ?> - University of Northampton</title>
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
			.breadcrumb {
				display: flex;
				gap: 10px;
				margin-bottom: 30px;
				font-size: 14px;
				color: #666;
			}
			.breadcrumb a {
				color: #1976d2;
				text-decoration: none;
			}
			.breadcrumb a:hover {
				text-decoration: underline;
			}
			.breadcrumb .separator {
				color: #ccc;
			}
			.course-header {
				background: white;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.08);
				margin-bottom: 30px;
				border-left: 6px solid #1976d2;
			}
			.course-header h1 {
				color: #333;
				margin: 0 0 20px 0;
				font-size: 32px;
				font-weight: 700;
			}
			.course-meta {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
				gap: 20px;
				margin-bottom: 20px;
			}
			.meta-item {
				display: flex;
				flex-direction: column;
				gap: 5px;
			}
			.meta-label {
				color: #999;
				font-size: 13px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.5px;
			}
			.meta-value {
				color: #333;
				font-size: 18px;
				font-weight: 700;
			}
			.meta-value.tag {
				display: inline-flex;
				align-items: center;
				background: #f0f0f0;
				padding: 6px 12px;
				border-radius: 4px;
				font-size: 14px;
				width: fit-content;
			}
			.subject-area-link {
				color: #1976d2;
				text-decoration: none;
				font-weight: 700;
			}
			.subject-area-link:hover {
				text-decoration: underline;
			}
			.description-section {
				background: white;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 2px 8px rgba(0,0,0,0.08);
				margin-bottom: 30px;
			}
			.description-section h2 {
				color: #333;
				margin: 0 0 15px 0;
				font-size: 20px;
				font-weight: 700;
			}
			.description-section p {
				color: #666;
				line-height: 1.6;
				margin: 0;
				white-space: pre-wrap;
				word-wrap: break-word;
			}
			.modules-section {
				background: white;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 2px 8px rgba(0,0,0,0.08);
				margin-bottom: 30px;
			}
			.modules-section h2 {
				color: #333;
				margin: 0 0 20px 0;
				font-size: 20px;
				font-weight: 700;
			}
			.modules-table {
				width: 100%;
				border-collapse: collapse;
				font-size: 14px;
			}
			.modules-table th {
				background: #f5f5f5;
				padding: 12px;
				text-align: left;
				color: #333;
				font-weight: 700;
				border-bottom: 2px solid #ddd;
			}
			.modules-table td {
				padding: 12px;
				border-bottom: 1px solid #eee;
				color: #666;
			}
			.modules-table tbody tr:hover {
				background: #f9f9f9;
			}
			.module-code {
				color: #333;
				font-weight: 700;
				font-family: monospace;
				background: #f0f0f0;
				padding: 2px 6px;
				border-radius: 3px;
				display: inline-block;
			}
			.empty-modules {
				text-align: center;
				padding: 40px;
				color: #999;
			}
			.back-button {
				display: inline-block;
				margin-bottom: 20px;
				padding: 12px 24px;
				background: #1976d2;
				color: white;
				text-decoration: none;
				border-radius: 4px;
				font-weight: 700;
				transition: background 0.3s;
			}
			.back-button:hover {
				background: #1565c0;
			}
			.error-message {
				background: #f8d7da;
				color: #721c24;
				padding: 20px;
				border-radius: 8px;
				text-align: center;
				border: 1px solid #f5c6cb;
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
				<?php if (isset($course) && $course): ?>
					<!-- Breadcrumb Navigation -->
					<div class="breadcrumb">
						<a href="/">Home</a>
						<span class="separator">/</span>
						<?php if (isset($subjectArea) && $subjectArea): ?>
							<a href="/subject-area/<?php echo $subjectArea['id']; ?>"><?php echo htmlspecialchars($subjectArea['name']); ?></a>
							<span class="separator">/</span>
						<?php endif; ?>
						<span><?php echo htmlspecialchars($course['title']); ?></span>
					</div>

					<!-- Course Header -->
					<div class="course-header">
						<h1><?php echo htmlspecialchars($course['title']); ?></h1>
						
						<div class="course-meta">
							<div class="meta-item">
								<span class="meta-label">Subject Area</span>
								<?php if (isset($subjectArea) && $subjectArea): ?>
									<a href="/subject-area/<?php echo $subjectArea['id']; ?>" class="subject-area-link">
										<?php echo htmlspecialchars($subjectArea['name']); ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="meta-item">
								<span class="meta-label">Course Type</span>
								<span class="meta-value"><?php echo htmlspecialchars($course['type']); ?></span>
							</div>
							<div class="meta-item">
								<span class="meta-label">Duration</span>
								<span class="meta-value"><?php echo $course['duration_years']; ?> year<?php echo $course['duration_years'] > 1 ? 's' : ''; ?></span>
							</div>
							<div class="meta-item">
								<span class="meta-label">Can be completed part time?</span>
								<span class="meta-value"><?php echo $course['part_time_available'] ? 'Yes' : 'No'; ?></span>
							</div>
							<?php if ($course['part_time_available']): ?>
								<div class="meta-item">
									<span class="meta-label">Availability</span>
									<span class="meta-value tag">✓ Part-time Available</span>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Course Description -->
					<div class="description-section">
						<h2>About This Course</h2>
						<p><?php echo htmlspecialchars($course['description']); ?></p>
					</div>

					<!-- Modules Section -->
					<div class="modules-section">
						<h2>Course Modules</h2>
						<?php if (isset($modules) && is_array($modules) && count($modules) > 0): ?>
							<table class="modules-table">
								<thead>
									<tr>
										<th style="width: 15%;">Code</th>
										<th style="width: 35%;">Title</th>
										<th style="width: 50%;">Description</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($modules as $module): ?>
										<tr>
											<td><span class="module-code"><?php echo htmlspecialchars($module['code']); ?></span></td>
											<td><?php echo htmlspecialchars($module['title']); ?></td>
											<td><?php echo htmlspecialchars($module['description']); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<div class="empty-modules">
								<p>No modules assigned to this course yet.</p>
							</div>
						<?php endif; ?>
					</div>

					<a href="<?php echo isset($subjectArea) ? '/subject-area/' . $subjectArea['id'] : '/'; ?>" class="back-button">
						← <?php echo isset($subjectArea) ? 'Back to ' . htmlspecialchars($subjectArea['name']) : 'Back to Home'; ?>
					</a>

				<?php else: ?>
					<div class="error-message">
						<h2>Course Not Found</h2>
						<p>The course you're looking for doesn't exist or has been removed.</p>
						<a href="/" class="back-button" style="margin-top: 20px;">← Return to Home</a>
					</div>
				<?php endif; ?>
			</div>
		</main>

		<aside>
            <p>Explore detailed information about our courses, including their modules, duration, and study options.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

