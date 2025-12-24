<!doctype html>
<html>
	<head>
		<title>Courses - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			main {
				display: flex;
				justify-content: center;
				padding: 40px 20px;
				background: #f8f9fa;
				min-height: 100vh;
			}
			.container {
				width: 100%;
				max-width: 600px;
				box-sizing: border-box;
			}
			.header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 50px;
				box-sizing: border-box;
			}
			.header h1 {
				margin: 0;
				color: #1a1a1a;
				font-size: 36px;
				font-weight: 800;
				letter-spacing: -0.5px;
			}
			.form-section {
				background: white;
				padding: 28px;
				border-radius: 12px;
				box-shadow: 0 2px 16px rgba(0,0,0,0.06);
				margin-bottom: 50px;
				border: 1px solid #f0f0f0;
				box-sizing: border-box;
				width: 100%;
			}
			.form-section h2 {
				color: #1a1a1a;
				margin: 0 0 30px 0;
				font-size: 22px;
				font-weight: 700;
				padding-bottom: 15px;
				border-bottom: 2px solid #f0f0f0;
				box-sizing: border-box;
			}
			.form-row {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 15px;
				margin-bottom: 25px;
				box-sizing: border-box;
			}
			.form-row.full {
				grid-template-columns: 1fr;
			}
			.form-group {
				margin-bottom: 0;
				box-sizing: border-box;
			}
			.form-group label {
				display: block;
				margin-bottom: 12px;
				font-weight: 600;
				color: #666;
				font-size: 14px;
				text-transform: uppercase;
				letter-spacing: 0.5px;
			}
			.form-group input,
			.form-group select,
			.form-group textarea {
				width: 100%;
				box-sizing: border-box;
				padding: 14px 16px;
				border: 1.5px solid #e0e0e0;
				border-radius: 8px;
				font-size: 15px;
				box-sizing: border-box;
				transition: all 0.3s ease;
				font-family: inherit;
				background: #fafbfc;
			}
			.form-group input:hover,
			.form-group select:hover,
			.form-group textarea:hover {
				border-color: #d0d0d0;
				background: #fff;
			}
			.form-group input:focus,
			.form-group select:focus,
			.form-group textarea:focus {
				outline: none;
				border-color: #1976d2;
				background: #fff;
				box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.08);
			}
			.form-group textarea {
				resize: vertical;
				min-height: 120px;
			}
			.checkbox-group {
				display: flex;
				align-items: center;
				gap: 12px;
				margin-top: 10px;
				padding: 10px 12px;
				background: #fafbfc;
				border: 1.5px solid #e0e0e0;
				border-radius: 8px;
				transition: all 0.3s ease;
				box-sizing: border-box;
			}
			.checkbox-group:hover {
				border-color: #d0d0d0;
				background: #fff;
			}
			.checkbox-group input[type="checkbox"] {
				width: auto;
				margin: 0;
				padding: 0;
				cursor: pointer;
				accent-color: #1976d2;
			}
			.checkbox-group label {
				margin: 0;
				font-weight: 500;
				cursor: pointer;
				color: #333;
			}
			.modules-section {
				background: white;
				padding: 40px;
				border-radius: 12px;
				margin-top: 30px;
				border: 1px solid #f0f0f0;
				box-shadow: 0 2px 16px rgba(0,0,0,0.06);
				box-sizing: border-box;
			}
			.modules-section h3 {
				color: #1a1a1a;
				margin: 0 0 30px 0;
				font-size: 17px;
				font-weight: 700;
				text-transform: uppercase;
				letter-spacing: 0.5px;
				padding-bottom: 15px;
				border-bottom: 2px solid #f0f0f0;
			}
			.modules-list {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
				gap: 16px;
				box-sizing: border-box;
			}
			.module-item {
				background: #fafbfc;
				padding: 18px;
				border: 1.5px solid #e8e8e8;
				border-radius: 10px;
				cursor: pointer;
				transition: all 0.3s ease;
				box-shadow: 0 2px 8px rgba(0,0,0,0.04);
			}
			.module-item:hover {
				border-color: #1976d2;
				background: white;
				box-shadow: 0 4px 14px rgba(25, 118, 210, 0.18);
				transform: translateY(-2px);
			}
			.module-item.selected {
				border-color: #1976d2;
				background: linear-gradient(135deg, #e3f2fd 0%, #fff 100%);
				box-shadow: 0 4px 14px rgba(25, 118, 210, 0.25);
			}
			.module-item input[type="checkbox"] {
				margin-right: 10px;
				cursor: pointer;
				accent-color: #1976d2;
			}
			.module-code {
				font-weight: 700;
				color: #1976d2;
				display: block;
				margin-bottom: 6px;
				font-family: 'Courier New', monospace;
				letter-spacing: 0.5px;
			}
			.module-title {
				font-size: 13px;
				color: #666;
				line-height: 1.4;
			}
			.form-actions {
				display: flex;
				gap: 12px;
				margin-top: 40px;
				padding-top: 30px;
				border-top: 2px solid #f0f0f0;
			}
			.btn {
				padding: 12px 28px;
				border: none;
				border-radius: 8px;
				cursor: pointer;
				font-size: 15px;
				font-weight: 700;
				transition: all 0.3s ease;
				text-decoration: none;
				display: inline-block;
				letter-spacing: 0.3px;
			}
			.btn-primary {
				background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
				color: white;
				box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
			}
			.btn-primary:hover {
				transform: translateY(-2px);
				box-shadow: 0 6px 16px rgba(25, 118, 210, 0.4);
			}
			.btn-secondary {
				background: #f0f0f0;
				color: #333;
				border: 1.5px solid #e0e0e0;
			}
			.btn-secondary:hover {
				background: #e8e8e8;
				border-color: #d0d0d0;
			}
			.btn-danger {
				background: #ef5350;
				color: white;
				box-shadow: 0 4px 12px rgba(239, 83, 80, 0.2);
			}
			.btn-danger:hover {
				background: #e53935;
				transform: translateY(-2px);
				box-shadow: 0 6px 16px rgba(239, 83, 80, 0.3);
			}
			.btn-small {
				padding: 8px 14px;
				font-size: 13px;
			}
			.alert {
				padding: 18px 24px;
				margin-bottom: 30px;
				border-radius: 10px;
				font-size: 14px;
				border-left: 4px solid;
			}
			.alert-danger {
				background: #ffebee;
				color: #c62828;
				border-left-color: #d32f2f;
			}
			.alert-success {
				background: #e8f5e9;
				color: #2e7d32;
				border-left-color: #4caf50;
			}
			.courses-grid {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
				gap: 25px;
				margin-top: 30px;
			}
			.course-card {
				background: white;
				border: 1px solid #f0f0f0;
				border-radius: 12px;
				padding: 25px;
				box-shadow: 0 2px 16px rgba(0,0,0,0.06);
				transition: all 0.3s ease;
				overflow: hidden;
			}
			.course-card:hover {
				box-shadow: 0 8px 24px rgba(0,0,0,0.12);
				border-color: #1976d2;
				transform: translateY(-4px);
			}
			.course-card h3 {
				margin: 0 0 15px 0;
				color: #1a1a1a;
				font-size: 18px;
				font-weight: 700;
			}
			.course-meta {
				display: flex;
				gap: 10px;
				margin-bottom: 18px;
				font-size: 12px;
				color: #666;
				flex-wrap: wrap;
			}
			.course-meta span {
				background: linear-gradient(135deg, #e3f2fd 0%, #f3f5f9 100%);
				padding: 6px 12px;
				border-radius: 6px;
				color: #0288d1;
				font-weight: 500;
			}
			.course-description {
				font-size: 13px;
				color: #666;
				line-height: 1.5;
				margin-bottom: 15px;
				display: -webkit-box;
				-webkit-line-clamp: 2;
				-webkit-box-orient: vertical;
				overflow: hidden;
			}
			.course-actions {
				display: flex;
				gap: 8px;
			}
			.empty-state {
				text-align: center;
				padding: 60px 20px;
				color: #999;
				background: white;
				border-radius: 8px;
				box-shadow: 0 2px 8px rgba(0,0,0,0.08);
			}
			.empty-state p {
				margin: 0;
				font-size: 16px;
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
				<div class="header">
					<h1>Courses Management</h1>
					<a href="/admin" class="btn btn-secondary">Back to Admin</a>
				</div>

				<?php if (isset($_GET['message'])): ?>
					<div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
				<?php endif; ?>

				<?php if (isset($error) && !empty($error)): ?>
					<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
				<?php endif; ?>

				<div class="form-section">
					<h2><?php echo (isset($editCourse) && $editCourse) ? 'Edit Course' : 'Add New Course'; ?></h2>
					
					<form method="POST" action="/courses/save">
						<?php if (isset($editCourse) && $editCourse): ?>
							<input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>" />
						<?php endif; ?>

						<!-- Course Title -->
						<div class="form-row full">
							<div class="form-group">
								<label for="title">Course Title *</label>
								<input 
									type="text" 
									id="title" 
									name="title" 
									required 
									maxlength="255"
									value="<?php echo (isset($editCourse) && $editCourse) ? htmlspecialchars($editCourse['title']) : ''; ?>"
									placeholder="e.g., Software Engineering, Data Science"
									autofocus
								/>
							</div>
						</div>

						<!-- Subject Area & Type -->
						<div class="form-row">
							<div class="form-group">
								<label for="subject_area_id">Subject Area *</label>
								<select id="subject_area_id" name="subject_area_id" required>
									<option value="">Select a subject area...</option>
									<?php foreach ($subjectAreas as $area): ?>
										<option value="<?php echo $area['id']; ?>" <?php echo (isset($editCourse) && $editCourse && $editCourse['subject_area_id'] == $area['id']) ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars($area['name']); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="type">Course Type *</label>
								<select id="type" name="type" required>
									<option value="">Select type...</option>
									<option value="BSc" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'BSc') ? 'selected' : ''; ?>>BSc (Bachelor of Science)</option>
									<option value="BA" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'BA') ? 'selected' : ''; ?>>BA (Bachelor of Arts)</option>
									<option value="MSc" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'MSc') ? 'selected' : ''; ?>>MSc (Master of Science)</option>
									<option value="MA" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'MA') ? 'selected' : ''; ?>>MA (Master of Arts)</option>
									<option value="PhD" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'PhD') ? 'selected' : ''; ?>>PhD</option>
									<option value="Diploma" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'Diploma') ? 'selected' : ''; ?>>Diploma</option>
									<option value="Certificate" <?php echo (isset($editCourse) && $editCourse && $editCourse['type'] == 'Certificate') ? 'selected' : ''; ?>>Certificate</option>
								</select>
							</div>
						</div>

						<!-- Duration -->
						<div class="form-row">
							<div class="form-group">
								<label for="duration_years">Duration (Years) *</label>
								<select id="duration_years" name="duration_years" required>
									<option value="">Select duration...</option>
									<?php for ($i = 1; $i <= 10; $i++): ?>
										<option value="<?php echo $i; ?>" <?php echo (isset($editCourse) && $editCourse && $editCourse['duration_years'] == $i) ? 'selected' : ''; ?>>
											<?php echo $i; ?> year<?php echo $i > 1 ? 's' : ''; ?>
										</option>
									<?php endfor; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Options</label>
								<div class="checkbox-group">
									<input 
										type="checkbox" 
										id="part_time" 
										name="part_time_available" 
										value="1"
										<?php echo (isset($editCourse) && $editCourse && $editCourse['part_time_available']) ? 'checked' : ''; ?>
									/>
									<label for="part_time">Part-time available</label>
								</div>
							</div>
						</div>

						<!-- Description -->
						<div class="form-row full">
							<div class="form-group">
								<label for="description">Course Description *</label>
								<textarea 
									id="description" 
									name="description" 
									required 
									placeholder="Detailed description of the course..."
								><?php echo (isset($editCourse) && $editCourse) ? htmlspecialchars($editCourse['description']) : ''; ?></textarea>
							</div>
						</div>

						<!-- Modules Selection -->
						<?php if (isset($allModules) && is_array($allModules) && count($allModules) > 0): ?>
							<div class="modules-section">
								<h3>Assign Modules to this Course</h3>
								<div class="modules-list">
									<?php foreach ($allModules as $module): ?>
										<?php 
											$isSelected = false;
											if (isset($editModules) && is_array($editModules)) {
												foreach ($editModules as $editMod) {
													if ($editMod['id'] == $module['id']) {
														$isSelected = true;
														break;
													}
												}
											}
										?>
										<div class="module-item <?php echo $isSelected ? 'selected' : ''; ?>" onclick="this.querySelector('input').checked = !this.querySelector('input').checked; this.classList.toggle('selected');">
											<input 
												type="checkbox" 
												name="module_ids[]" 
												value="<?php echo $module['id']; ?>"
												<?php echo $isSelected ? 'checked' : ''; ?>
											/>
											<span class="module-code"><?php echo htmlspecialchars($module['code']); ?></span>
											<span class="module-title"><?php echo htmlspecialchars($module['title']); ?></span>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<div class="form-actions">
							<button type="submit" class="btn btn-primary">
								<?php echo (isset($editCourse) && $editCourse) ? 'Update Course' : 'Create Course'; ?>
							</button>
							<?php if (isset($editCourse) && $editCourse): ?>
								<a href="/courses" class="btn btn-secondary">Cancel</a>
							<?php endif; ?>
						</div>
					</form>
				</div>

				<h2 style="color: #333; margin: 40px 0 20px 0; font-size: 24px; font-weight: 700;">All Courses</h2>

				<?php if (is_array($courses) && count($courses) > 0): ?>
					<div class="courses-grid">
						<?php foreach ($courses as $course): 
							$subjectArea = null;
							foreach ($subjectAreas as $area) {
								if ($area['id'] == $course['subject_area_id']) {
									$subjectArea = $area;
									break;
								}
							}
						?>
							<div class="course-card">
								<h3><?php echo htmlspecialchars($course['title']); ?></h3>
								<div class="course-meta">
									<span><?php echo htmlspecialchars($course['type']); ?></span>
									<span><?php echo $course['duration_years']; ?> year<?php echo $course['duration_years'] > 1 ? 's' : ''; ?></span>
									<?php if ($subjectArea): ?>
										<span><?php echo htmlspecialchars($subjectArea['name']); ?></span>
									<?php endif; ?>
									<?php if ($course['part_time_available']): ?>
										<span>Part-time</span>
									<?php endif; ?>
								</div>
								<p class="course-description"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
								<div class="course-actions">
									<a href="/courses?edit=<?php echo $course['id']; ?>" class="btn btn-small btn-primary">Edit</a>
									<a href="/courses/delete/<?php echo $course['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
									<a href="/course/<?php echo $course['id']; ?>" class="btn btn-small btn-secondary">View</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<div class="empty-state">
						<p>No courses yet. Create one using the form above to get started!</p>
					</div>
				<?php endif; ?>
			</div>
		</main>

		<aside>
            <p>Manage all courses offered at the university. Each course is assigned to a subject area and can include multiple modules.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

