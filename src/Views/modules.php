<!doctype html>
<html>

<head>
	<title>Modules - University of Northampton</title>
	<link rel="stylesheet" href="/uon.css?v=2" />
	<style>
		.container {
			width: 100%;
			max-width: 100%;
			box-sizing: border-box;
		}

		.header-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 30px;
		}

		.header-row h1 {
			margin: 0;
			color: #333;
			font-size: 28px;
			font-weight: 700;
		}

		.form-section {
			background: white;
			padding: 25px;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			margin-bottom: 30px;
		}

		.form-section h2 {
			color: #333;
			margin: 0 0 20px 0;
			font-size: 18px;
			font-weight: 700;
		}

		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 15px;
			margin-bottom: 20px;
		}

		.form-row.full {
			grid-template-columns: 1fr;
		}

		.form-group {
			margin-bottom: 0;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #333;
			font-size: 14px;
		}

		.form-group input,
		.form-group textarea {
			width: 100%;
			padding: 10px 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			box-sizing: border-box;
		}

		.form-group input:focus,
		.form-group textarea:focus {
			outline: none;
			border-color: #1976d2;
		}

		.form-group textarea {
			resize: vertical;
			min-height: 100px;
		}

		.code-info {
			font-size: 12px;
			color: #999;
			margin-top: 4px;
			font-style: italic;
		}

		.form-actions {
			display: flex;
			gap: 10px;
			margin-top: 20px;
		}

		.btn {
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
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
			padding: 6px 12px;
			font-size: 13px;
		}

		.alert {
			padding: 12px 15px;
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

		.modules-table {
			width: 100%;
			border-collapse: collapse;
			background: white;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			font-size: 14px;
		}

		.modules-table th {
			background: #f5f5f5;
			padding: 12px 15px;
			text-align: left;
			color: #333;
			font-weight: 700;
			border-bottom: 2px solid #ddd;
		}

		.modules-table td {
			padding: 12px 15px;
			border-bottom: 1px solid #eee;
			color: #666;
		}

		.modules-table tbody tr:hover {
			background: #f9f9f9;
		}

		.module-code {
			font-weight: 700;
			color: #1976d2;
			font-family: monospace;
			background: #f0f7ff;
			padding: 4px 8px;
			border-radius: 3px;
			display: inline-block;
		}

		.module-title {
			font-weight: 600;
			color: #333;
		}

		.module-description {
			font-size: 13px;
			color: #999;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		.module-actions {
			display: flex;
			gap: 8px;
		}

		.empty-state {
			text-align: center;
			padding: 40px 20px;
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
			<div class="header-row">
				<h1>Modules Management</h1>
				<a href="/admin" class="btn btn-secondary">Back to Admin</a>
			</div>

			<?php if (isset($_GET['message'])): ?>
				<div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
			<?php endif; ?>

			<?php if (isset($error) && !empty($error)): ?>
				<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
			<?php endif; ?>

			<div class="form-section">
				<h2><?php echo (isset($editModule) && $editModule) ? 'Edit Module' : 'Add New Module'; ?></h2>

				<form method="POST" action="/modules/save">
					<?php if (isset($editModule) && $editModule): ?>
						<input type="hidden" name="id" value="<?php echo $editModule['id']; ?>" />
					<?php endif; ?>

					<div class="form-row">
						<div class="form-group">
							<label for="code">Module Code *</label>
							<input type="text" id="code" name="code" required maxlength="50"
								placeholder="e.g., CS101, ML201"
								value="<?php echo (isset($editModule) && $editModule) ? htmlspecialchars($editModule['code']) : ''; ?>"
								autofocus />
							<div class="code-info">Letters and numbers only (e.g., CS101, MATH201)</div>
						</div>
						<div class="form-group">
							<label for="title">Module Title *</label>
							<input type="text" id="title" name="title" required maxlength="255"
								placeholder="e.g., Introduction to Computer Science"
								value="<?php echo (isset($editModule) && $editModule) ? htmlspecialchars($editModule['title']) : ''; ?>" />
						</div>
					</div>

					<div class="form-row full">
						<div class="form-group">
							<label for="description">Module Description *</label>
							<textarea id="description" name="description" required
								placeholder="Detailed description of what students will learn in this module..."><?php echo (isset($editModule) && $editModule) ? htmlspecialchars($editModule['description']) : ''; ?></textarea>
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-primary">
							<?php echo (isset($editModule) && $editModule) ? 'Update Module' : 'Create Module'; ?>
						</button>
						<?php if (isset($editModule) && $editModule): ?>
							<a href="/modules" class="btn btn-secondary">Cancel</a>
						<?php endif; ?>
					</div>
				</form>
			</div>

			<h2 style="color: #333; margin: 30px 0 15px 0; font-size: 20px; font-weight: 700;">All Modules</h2>

			<?php if (is_array($modules) && count($modules) > 0): ?>
				<table class="modules-table">
					<thead>
						<tr>
							<th style="width: 12%;">Code</th>
							<th style="width: 25%;">Title</th>
							<th style="width: 50%;">Description</th>
							<th style="width: 13%;">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($modules as $module): ?>
							<tr>
								<td><span class="module-code"><?php echo htmlspecialchars($module['code']); ?></span></td>
								<td><span class="module-title"><?php echo htmlspecialchars($module['title']); ?></span></td>
								<td><span
										class="module-description"><?php echo htmlspecialchars($module['description']); ?></span>
								</td>
								<td>
									<div class="module-actions">
										<a href="/modules?edit=<?php echo $module['id']; ?>"
											class="btn btn-small btn-primary">Edit</a>
										<a href="/modules/delete/<?php echo $module['id']; ?>" class="btn btn-small btn-danger"
											onclick="return confirm('Are you sure you want to delete this module?');">Delete</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="empty-state">
					<p>No modules yet. Create one using the form above to get started!</p>
				</div>
			<?php endif; ?>
		</div>
	</main>

	<aside>
		<p>Manage all course modules. Create new modules and assign them to courses.</p>
	</aside>

	<footer>
		&copy; 2025 University of Northampton
	</footer>

</body>

</html>