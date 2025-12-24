<!doctype html>
<html>
	<head>
		<title>Search Courses - University of Northampton</title>
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
			.search-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 30px;
			}
			.search-header h1 {
				margin: 0;
				color: #333;
				font-size: 32px;
				font-weight: 700;
			}
			.search-form-section {
				background: white;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.08);
				margin-bottom: 30px;
			}
			.search-form-section h2 {
				color: #333;
				margin: 0 0 25px 0;
				font-size: 20px;
				font-weight: 700;
			}
			.form-grid {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 20px;
				margin-bottom: 20px;
			}
			.form-grid-full {
				grid-column: 1 / -1;
			}
			.form-group {
				display: flex;
				flex-direction: column;
			}
			.form-group label {
				color: #333;
				font-weight: 600;
				margin-bottom: 8px;
				font-size: 14px;
			}
			.form-group select,
			.form-group input {
				padding: 10px 12px;
				border: 1px solid #ddd;
				border-radius: 4px;
				font-size: 14px;
				font-family: inherit;
				transition: border-color 0.3s;
			}
			.form-group select:focus,
			.form-group input:focus {
				outline: none;
				border-color: #1976d2;
				box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.1);
			}
			.duration-inputs {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 15px;
			}
			.duration-inputs .form-group {
				margin-bottom: 0;
			}
			.search-buttons {
				display: flex;
				gap: 12px;
				justify-content: flex-end;
			}
			.btn {
				display: inline-block;
				padding: 12px 24px;
				background: #1976d2;
				color: white;
				text-decoration: none;
				border: none;
				border-radius: 4px;
				font-weight: 700;
				transition: background 0.3s;
				cursor: pointer;
				font-size: 14px;
			}
			.btn:hover {
				background: #1565c0;
			}
			.btn-secondary {
				background: #757575;
			}
			.btn-secondary:hover {
				background: #616161;
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
			.search-info {
				background: #e3f2fd;
				border-left: 4px solid #1976d2;
				padding: 12px 16px;
				margin-bottom: 20px;
				border-radius: 2px;
				color: #0d47a1;
				font-size: 14px;
			}
			.search-hint {
				color: #999;
				font-size: 12px;
				margin-top: 8px;
				font-style: italic;
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
				<div class="search-header">
					<h1>Search Courses</h1>
					<a href="/" class="btn">Back Home</a>
				</div>

				<div class="search-form-section">
					<h2>Filter by your preferences</h2>
					
					<form method="POST" action="/course-search">
						<div class="form-grid">
							<!-- Subject Area Filter -->
							<div class="form-group">
								<label for="subject_area_id">Subject Area</label>
								<select id="subject_area_id" name="subject_area_id">
									<option value="">-- All Subject Areas --</option>
									<?php foreach ($subjectAreas as $area): ?>
										<option value="<?php echo $area['id']; ?>" 
											<?php echo isset($_POST['subject_area_id']) && $_POST['subject_area_id'] == $area['id'] ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars($area['name']); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<!-- Course Type Filter -->
							<div class="form-group">
								<label for="type">Course Type</label>
								<select id="type" name="type">
									<option value="">-- All Types --</option>
									<?php foreach ($courseTypes as $courseType): ?>
										<option value="<?php echo htmlspecialchars($courseType); ?>"
											<?php echo isset($_POST['type']) && $_POST['type'] == $courseType ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars($courseType); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<!-- Duration Filter -->
							<div class="form-group form-grid-full">
								<label>Duration (years)</label>
								<div class="duration-inputs">
									<div class="form-group">
										<label for="min_duration">Minimum</label>
										<input type="number" id="min_duration" name="min_duration" min="1" max="10" placeholder="e.g. 2"
											<?php echo isset($_POST['min_duration']) && $_POST['min_duration'] !== '' ? 'value="' . htmlspecialchars($_POST['min_duration']) . '"' : ''; ?> />
									</div>
									<div class="form-group">
										<label for="max_duration">Maximum</label>
										<input type="number" id="max_duration" name="max_duration" min="1" max="10" placeholder="e.g. 4"
											<?php echo isset($_POST['max_duration']) && $_POST['max_duration'] !== '' ? 'value="' . htmlspecialchars($_POST['max_duration']) . '"' : ''; ?> />
									</div>
								</div>
								<p class="search-hint">Leave blank to include all durations. Min must be ≤ Max if both specified.</p>
							</div>

							<!-- Part-time Filter -->
							<div class="form-group form-grid-full">
								<label style="display: flex; align-items: center; gap: 8px; text-transform: none; margin: 0; font-weight: 500; color: #333;">
									<input type="checkbox" id="part_time_only" name="part_time_only" 
										<?php echo isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? 'checked' : ''; ?> 
										style="width: auto; padding: 0; margin: 0; cursor: pointer;" />
									<span>Part-time available only</span>
								</label>
								<p class="search-hint">Check to see only courses that can be completed part-time.</p>
							</div>
						</div>

						<div class="search-buttons">
							<button type="reset" class="btn btn-secondary">Clear</button>
							<button type="submit" class="btn">Search Courses</button>
						</div>
					</form>
				</div>

				<!-- Search Results Section -->
				<?php if ($searchPerformed): ?>
					<div class="courses-section">
						<?php if (is_array($searchResults) && count($searchResults) > 0): ?>
							<div class="search-info">
								Found <strong><?php echo count($searchResults); ?></strong> course<?php echo count($searchResults) > 1 ? 's' : ''; ?> on this page matching your criteria.
							</div>
							<h2>Search Results</h2>
							
							<?php foreach ($searchResults as $course): ?>
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

							<!-- Pagination for Search Results -->
							<?php if (isset($totalPages) && $totalPages > 1): ?>
								<div style="display: flex; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;">
									<!-- Previous Button -->
									<?php if ($currentPage > 1): ?>
										<form method="POST" style="display: inline; margin: 0; padding: 0;">
											<input type="hidden" name="subject_area_id" value="<?php echo isset($_POST['subject_area_id']) ? htmlspecialchars($_POST['subject_area_id']) : ''; ?>" />
											<input type="hidden" name="type" value="<?php echo isset($_POST['type']) ? htmlspecialchars($_POST['type']) : ''; ?>" />
											<input type="hidden" name="min_duration" value="<?php echo isset($_POST['min_duration']) ? htmlspecialchars($_POST['min_duration']) : ''; ?>" />
											<input type="hidden" name="max_duration" value="<?php echo isset($_POST['max_duration']) ? htmlspecialchars($_POST['max_duration']) : ''; ?>" />
											<?php if (isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on'): ?>
												<input type="hidden" name="part_time_only" value="on" />
											<?php endif; ?>
											<button type="submit" formaction="?page=<?php echo $currentPage - 1; ?>" style="padding: 8px 12px; background: #1976d2; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#1565c0'" onmouseout="this.style.background='#1976d2'">← Previous</button>
										</form>
									<?php endif; ?>

									<!-- Page Numbers -->
									<?php
										$startPage = max(1, $currentPage - 2);
										$endPage = min($totalPages, $currentPage + 2);

										if ($startPage > 1) {
											echo '<form method="POST" style="display: inline; margin: 0; padding: 0;"><input type="hidden" name="subject_area_id" value="' . (isset($_POST['subject_area_id']) ? htmlspecialchars($_POST['subject_area_id']) : '') . '" /><input type="hidden" name="type" value="' . (isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '') . '" /><input type="hidden" name="min_duration" value="' . (isset($_POST['min_duration']) ? htmlspecialchars($_POST['min_duration']) : '') . '" /><input type="hidden" name="max_duration" value="' . (isset($_POST['max_duration']) ? htmlspecialchars($_POST['max_duration']) : '') . '" />' . (isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? '<input type="hidden" name="part_time_only" value="on" />' : '') . '<button type="submit" formaction="?page=1" style="padding: 8px 12px; background: #f0f0f0; border: none; border-radius: 4px; font-weight: 600; cursor: pointer;">1</button></form>';
											if ($startPage > 2) {
												echo '<span style="padding: 8px 12px; color: #999;">...</span>';
											}
										}

										for ($i = $startPage; $i <= $endPage; $i++) {
											if ($i == $currentPage) {
												echo '<span style="padding: 8px 12px; background: #1976d2; color: white; border-radius: 4px; font-weight: 600;">' . $i . '</span>';
											} else {
												echo '<form method="POST" style="display: inline; margin: 0; padding: 0;"><input type="hidden" name="subject_area_id" value="' . (isset($_POST['subject_area_id']) ? htmlspecialchars($_POST['subject_area_id']) : '') . '" /><input type="hidden" name="type" value="' . (isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '') . '" /><input type="hidden" name="min_duration" value="' . (isset($_POST['min_duration']) ? htmlspecialchars($_POST['min_duration']) : '') . '" /><input type="hidden" name="max_duration" value="' . (isset($_POST['max_duration']) ? htmlspecialchars($_POST['max_duration']) : '') . '" />' . (isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? '<input type="hidden" name="part_time_only" value="on" />' : '') . '<button type="submit" formaction="?page=' . $i . '" style="padding: 8px 12px; background: #f0f0f0; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e0e0e0\'" onmouseout="this.style.background=\'#f0f0f0\'">' . $i . '</button></form>';
											}
										}

										if ($endPage < $totalPages) {
											if ($endPage < $totalPages - 1) {
												echo '<span style="padding: 8px 12px; color: #999;">...</span>';
											}
											echo '<form method="POST" style="display: inline; margin: 0; padding: 0;"><input type="hidden" name="subject_area_id" value="' . (isset($_POST['subject_area_id']) ? htmlspecialchars($_POST['subject_area_id']) : '') . '" /><input type="hidden" name="type" value="' . (isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '') . '" /><input type="hidden" name="min_duration" value="' . (isset($_POST['min_duration']) ? htmlspecialchars($_POST['min_duration']) : '') . '" /><input type="hidden" name="max_duration" value="' . (isset($_POST['max_duration']) ? htmlspecialchars($_POST['max_duration']) : '') . '" />' . (isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? '<input type="hidden" name="part_time_only" value="on" />' : '') . '<button type="submit" formaction="?page=' . $totalPages . '" style="padding: 8px 12px; background: #f0f0f0; border: none; border-radius: 4px; font-weight: 600; cursor: pointer;">' . $totalPages . '</button></form>';
										}
									?>

									<!-- Next Button -->
									<?php if ($currentPage < $totalPages): ?>
										<form method="POST" style="display: inline; margin: 0; padding: 0;">
											<input type="hidden" name="subject_area_id" value="<?php echo isset($_POST['subject_area_id']) ? htmlspecialchars($_POST['subject_area_id']) : ''; ?>" />
											<input type="hidden" name="type" value="<?php echo isset($_POST['type']) ? htmlspecialchars($_POST['type']) : ''; ?>" />
											<input type="hidden" name="min_duration" value="<?php echo isset($_POST['min_duration']) ? htmlspecialchars($_POST['min_duration']) : ''; ?>" />
											<input type="hidden" name="max_duration" value="<?php echo isset($_POST['max_duration']) ? htmlspecialchars($_POST['max_duration']) : ''; ?>" />
											<?php if (isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on'): ?>
												<input type="hidden" name="part_time_only" value="on" />
											<?php endif; ?>
											<button type="submit" formaction="?page=<?php echo $currentPage + 1; ?>" style="padding: 8px 12px; background: #1976d2; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#1565c0'" onmouseout="this.style.background='#1976d2'">Next →</button>
										</form>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php else: ?>
							<div class="empty-state">
								<p>No courses found matching your search criteria.</p>
								<p style="font-size: 13px; margin-top: 10px; color: #ccc;">Try adjusting your filters.</p>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</main>

		<aside>
            <h3>Course Search</h3>
            <p>Use the search form above to find courses by subject area, type, or duration. You can combine any criteria to narrow down your options.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

