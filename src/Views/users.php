<!doctype html>
<html>
	<head>
		<title>Manage Staff - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			.admin-controls {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 20px;
			}
			.btn-primary {
				background: #1976d2;
				color: white;
				padding: 10px 20px;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				text-decoration: none;
				display: inline-block;
			}
			.btn-primary:hover {
				background: #1565c0;
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
			}
			.btn-logout:hover {
				background: #b71c1c;
			}
			.alert {
				padding: 15px;
				margin-bottom: 20px;
				border-radius: 4px;
				font-size: 14px;
			}
			.alert-success {
				background: #d4edda;
				color: #155724;
				border: 1px solid #c3e6cb;
			}
			.users-table {
				width: 100%;
				border-collapse: collapse;
				background: white;
				border-radius: 4px;
				overflow: hidden;
				box-shadow: 0 2px 4px rgba(0,0,0,0.1);
			}
			.users-table thead {
				background: #f5f5f5;
				border-bottom: 2px solid #ddd;
			}
			.users-table th {
				padding: 15px;
				text-align: left;
				font-weight: 600;
				color: #333;
			}
			.users-table td {
				padding: 15px;
				border-bottom: 1px solid #eee;
			}
			.users-table tr:hover {
				background: #f9f9f9;
			}
			.role-badge {
				display: inline-block;
				padding: 4px 12px;
				border-radius: 20px;
				font-size: 12px;
				font-weight: 600;
			}
			.role-superadmin {
				background: #ffebee;
				color: #c62828;
			}
			.role-staff {
				background: #e3f2fd;
				color: #1565c0;
			}
			.btn-delete {
				background: #d32f2f;
				color: white;
				padding: 6px 12px;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				font-size: 12px;
				text-decoration: none;
				display: inline-block;
			}
			.btn-delete:hover {
				background: #b71c1c;
			}
			.btn-delete:disabled {
				background: #ccc;
				cursor: not-allowed;
			}
			.current-user {
				background: #fffacd;
				padding: 8px;
				border-radius: 4px;
				font-size: 12px;
				color: #666;
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
			<h1>Manage Staff Accounts</h1>

			<?php if ($message): ?>
				<div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
			<?php endif; ?>

			<div class="admin-controls">
				<a href="/users/create" class="btn-primary">+ Add New Staff Member</a>
				<a href="/logout" class="btn-logout">Logout</a>
			</div>

			<?php if (!empty($users)): ?>
				<table class="users-table">
					<thead>
						<tr>
							<th>Username</th>
							<th>Role</th>
							<th>Created</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $u): ?>
							<tr>
								<td>
									<?php echo htmlspecialchars($u['username']); ?>
									<?php if ($u['id'] == \App\Helpers\Auth::getUserId()): ?>
										<div class="current-user">You (current user)</div>
									<?php endif; ?>
								</td>
								<td>
									<span class="role-badge role-<?php echo $u['role']; ?>">
										<?php echo strtoupper($u['role']); ?>
									</span>
								</td>
								<td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
								<td>
									<?php if ($u['role'] === 'superadmin' || $u['id'] == 1): ?>
										<button class="btn-delete" disabled title="Cannot delete superadmin">Delete</button>
									<?php else: ?>
										<a href="/users/delete?id=<?php echo $u['id']; ?>" class="btn-delete">Delete</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<p>No staff members found.</p>
			<?php endif; ?>
		</main>

		<aside>
            <p>Use this page to manage staff member accounts. Only the superadmin can add or remove staff members.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

