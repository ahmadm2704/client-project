<!doctype html>
<html>

<head>
	<title>Subject Areas - University of Northampton</title>
	<link rel="stylesheet" href="/uon.css?v=2" />
	<style>
		main {
			display: flex;
			justify-content: center;
			padding: 40px 20px;
		}

		.container {
			width: 100%;
			max-width: 1000px;
		}

		.subject-areas-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 40px;
		}

		.subject-areas-header h1 {
			margin: 0;
			color: #333;
			font-size: 32px;
			font-weight: 700;
		}

		.form-section {
			background: white;
			padding: 30px;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
			margin-bottom: 40px;
		}

		.form-section h2 {
			color: #333;
			margin: 0 0 25px 0;
			font-size: 20px;
			font-weight: 700;
		}

		.form-inline {
			display: flex;
			gap: 12px;
			align-items: flex-end;
		}

		.form-group {
			flex: 1;
			margin-bottom: 0;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #333;
			font-size: 14px;
		}

		.form-group input {
			width: 100%;
			padding: 12px 14px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			box-sizing: border-box;
			transition: border-color 0.3s;
		}

		.form-group input:focus {
			outline: none;
			border-color: #1976d2;
			box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
		}

		.btn {
			padding: 12px 24px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			font-weight: 700;
			transition: background 0.3s;
			text-decoration: none;
			display: inline-block;
		}

		.btn-primary {
			background: #1976d2;
			color: white;
		}

		.btn-primary:hover {
			background: #1565c0;
		}

		.btn-secondary {
			background: #757575;
			color: white;
		}

		.btn-secondary:hover {
			background: #616161;
		}

		.btn-danger {
			background: #d32f2f;
			color: white;
		}

		.btn-danger:hover {
			background: #c62828;
		}

		.btn-small {
			padding: 8px 12px;
			font-size: 14px;
		}

		.alert {
			padding: 15px;
			margin-bottom: 20px;
			border-radius: 4px;
			font-size: 14px;
		}

		.alert-danger {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

		.alert-success {
			background: #d4edda;
			color: #155724;
			border: 1px solid #c3e6cb;
		}

		.subjects-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
			gap: 20px;
			margin-top: 30px;
		}

		.subject-card {
			background: white;
			border: 1px solid #eee;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			transition: all 0.3s;
			display: flex;
			flex-direction: column;
		}

		.subject-card:hover {
			box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
			border-color: #1976d2;
		}

		.subject-card h3 {
			margin: 0 0 15px 0;
			color: #333;
			font-size: 18px;
			font-weight: 700;
		}

		.subject-card-actions {
			display: flex;
			gap: 8px;
			margin-top: auto;
		}

		.empty-state {
			text-align: center;
			padding: 60px 20px;
			color: #999;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
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
			<div class="subject-areas-header">
				<h1>Subject Areas Management</h1>
				<a href="/admin" class="btn btn-secondary">Back to Admin</a>
			</div>

			<?php if (isset($_GET['message'])): ?>
				<div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
			<?php endif; ?>

			<?php if (isset($error) && !empty($error)): ?>
				<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
			<?php endif; ?>

			<div class="form-section">
				<h2><?php echo (isset($editSubjectArea) && $editSubjectArea) ? 'Edit Subject Area' : 'Add New Subject Area'; ?>
				</h2>

				<form method="POST" action="/subject-areas/save">
					<?php if (isset($editSubjectArea) && $editSubjectArea): ?>
						<input type="hidden" name="id" value="<?php echo $editSubjectArea['id']; ?>" />
					<?php endif; ?>

					<div class="form-inline">
						<div class="form-group" style="flex: 2;">
							<label for="name">Subject Area Name *</label>
							<input type="text" id="name" name="name" required maxlength="150"
								value="<?php echo (isset($editSubjectArea) && $editSubjectArea) ? htmlspecialchars($editSubjectArea['name']) : ''; ?>"
								placeholder="e.g., Computing, Business, Biomedical Science" autofocus />
						</div>

						<div style="display: flex; gap: 12px; align-items: flex-end;">
							<button type="submit" class="btn btn-primary">
								<?php echo (isset($editSubjectArea) && $editSubjectArea) ? 'Update' : 'Create'; ?>
							</button>
							<?php if (isset($editSubjectArea) && $editSubjectArea): ?>
								<a href="/subject-areas" class="btn btn-secondary">Cancel</a>
							<?php endif; ?>
						</div>
					</div>
				</form>
			</div>

			<h2 style="color: #333; margin: 40px 0 20px 0; font-size: 24px; font-weight: 700;">All Subject Areas</h2>

			<?php if (is_array($subjectAreas) && count($subjectAreas) > 0): ?>
				<div class="subjects-grid">
					<?php foreach ($subjectAreas as $subject): ?>
						<div class="subject-card">
							<h3><?php echo htmlspecialchars($subject['name']); ?></h3>
							<div class="subject-card-actions">
								<a href="/subject-areas?edit=<?php echo $subject['id']; ?>"
									class="btn btn-small btn-primary">Edit</a>
								<a href="/subject-areas/delete/<?php echo $subject['id']; ?>" class="btn btn-small btn-danger"
									onclick="return confirm('Are you sure you want to delete this subject area?');">Delete</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<div class="empty-state">
					<p>No subject areas yet. Create one using the form above to get started!</p>
				</div>
			<?php endif; ?>
		</div>
	</main>

	<aside>
		<p>Manage subject areas which are used to group courses on the website. Each course must be assigned to a
			subject area.</p>
	</aside>

	<footer>
		&copy; 2025 University of Northampton
	</footer>

</body>

</html>
