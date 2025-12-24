<!doctype html>
<html>
	<head>
		<title>Admin Dashboard - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			.dashboard-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 30px;
			}
			.dashboard-header h1 {
				margin: 0;
			}
			.user-info {
				text-align: right;
				font-size: 14px;
			}
			.user-info p {
				margin: 5px 0;
			}
			.btn-logout {
				background: #d32f2f;
				color: white;
				padding: 10px 20px;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				text-decoration: none;
				display: inline-block;
				margin-top: 10px;
			}
			.btn-logout:hover {
				background: #b71c1c;
			}
			.dashboard-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
				gap: 20px;
				margin-top: 20px;
			}
			.dashboard-card {
				background: white;
				padding: 25px;
				border-radius: 8px;
				box-shadow: 0 2px 8px rgba(0,0,0,0.1);
				text-align: center;
				text-decoration: none;
				color: inherit;
				transition: transform 0.2s, box-shadow 0.2s;
			}
			.dashboard-card:hover {
				transform: translateY(-4px);
				box-shadow: 0 4px 16px rgba(0,0,0,0.15);
			}
			.dashboard-card h3 {
				margin: 0 0 15px 0;
				color: #333;
			}
			.dashboard-card p {
				margin: 0 0 15px 0;
				color: #666;
				font-size: 14px;
			}
			.card-icon {
				font-size: 40px;
				margin-bottom: 10px;
			}
			.btn-action {
				background: #1976d2;
				color: white;
				padding: 10px 20px;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				text-decoration: none;
				display: inline-block;
				transition: background 0.3s;
			}
			.btn-action:hover {
				background: #1565c0;
			}
			.card-superadmin {
				border: 2px solid #ffebee;
				background: #fffcfd;
			}
			.card-superadmin .card-icon {
				color: #c62828;
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
			<div class="dashboard-header">
				<div>
					<h1>Admin Dashboard</h1>
				</div>
				<div class="user-info">
					<p>Welcome, <strong><?php echo htmlspecialchars(\App\Helpers\Auth::getUsername()); ?></strong></p>
					<?php if (\App\Helpers\Auth::isSuperAdmin()): ?>
						<p style="color: #c62828; font-weight: 600;">Superadmin</p>
					<?php endif; ?>
					<a href="/logout" class="btn-logout">Logout</a>
				</div>
			</div>

			<h2>Management Options</h2>

			<div class="dashboard-grid">
				<?php if (\App\Helpers\Auth::isSuperAdmin()): ?>
					<a href="/users" class="dashboard-card card-superadmin">
						<div class="card-icon">👥</div>
						<h3>Manage Staff</h3>
						<p>Add or remove staff members</p>
						<button class="btn-action">Manage Staff</button>
					</a>
				<?php endif; ?>

				<a href="/subject-areas" class="dashboard-card">
					<div class="card-icon">📚</div>
					<h3>Subject Areas</h3>
					<p>Manage course categories</p>
					<button class="btn-action">Manage Areas</button>
				</a>

				<a href="/courses" class="dashboard-card">
					<div class="card-icon">🎓</div>
					<h3>Courses</h3>
					<p>Add and manage courses</p>
					<button class="btn-action">Manage Courses</button>
				</a>

				<a href="/modules" class="dashboard-card">
					<div class="card-icon">📖</div>
					<h3>Modules</h3>
					<p>Create and manage course modules</p>
					<button class="btn-action">Manage Modules</button>
				</a>

				<a href="/enquiries" class="dashboard-card">
					<div class="card-icon">📧</div>
					<h3>Enquiries</h3>
					<p>View and respond to student enquiries</p>
					<button class="btn-action">View Enquiries</button>
				</a>
			</div>
		</main>

		<aside>
			<h3>Quick Actions</h3>
			<ul style="padding-left: 20px;">
				<?php if (\App\Helpers\Auth::isSuperAdmin()): ?>
					<li><a href="/users">Manage Staff</a></li>
				<?php endif; ?>
				<li><a href="/subject-areas">Subject Areas</a></li>
				<li><a href="/modules">Modules</a></li>
				<li><a href="/courses">Courses</a></li>
				<li><a href="/enquiries">Enquiries</a></li>
			</ul>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

