<!doctype html>
<html>

<head>
	<title>Manage Enquiries - University of Northampton</title>
	<link rel="stylesheet" href="/uon.css?v=2" />
	<style>
		.page-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 25px;
		}

		.page-header h1 {
			margin: 0;
			color: #333;
			font-size: 28px;
			font-weight: 700;
		}

		.filter-section {
			display: flex;
			gap: 10px;
			margin-bottom: 25px;
			flex-wrap: wrap;
		}

		.filter-btn {
			padding: 8px 14px;
			border: 1px solid #ddd;
			border-radius: 4px;
			background: white;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
			text-decoration: none;
			display: inline-block;
			color: #333;
		}

		.filter-btn:hover {
			border-color: #1976d2;
			color: #1976d2;
		}

		.filter-btn.active {
			background: #1976d2;
			color: white;
			border-color: #1976d2;
		}

		.alert {
			padding: 12px 14px;
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

		.enquiries-table {
			width: 100%;
			border-collapse: collapse;
			background: white;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			font-size: 14px;
		}

		.enquiries-table th {
			background: #f5f5f5;
			padding: 12px 10px;
			text-align: left;
			color: #333;
			font-weight: 700;
			border-bottom: 2px solid #ddd;
		}

		.enquiries-table td {
			padding: 12px 10px;
			border-bottom: 1px solid #eee;
			color: #666;
			vertical-align: top;
		}

		.enquiries-table tbody tr:hover {
			background: #f9f9f9;
		}

		.status-badge {
			display: inline-block;
			padding: 4px 10px;
			border-radius: 12px;
			font-size: 12px;
			font-weight: 600;
		}

		.status-new {
			background: #fff3cd;
			color: #856404;
		}

		.status-responded {
			background: #d4edda;
			color: #155724;
		}

		.enquiry-actions {
			display: flex;
			gap: 6px;
			flex-wrap: wrap;
		}

		.btn {
			padding: 6px 10px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 12px;
			font-weight: 600;
			text-decoration: none;
			display: inline-block;
		}

		.btn-view {
			background: #1976d2;
			color: white;
		}

		.btn-view:hover {
			background: #1565c0;
		}

		.btn-danger {
			background: #d32f2f;
			color: white;
		}

		.btn-danger:hover {
			background: #c62828;
		}

		.btn-secondary {
			background: #757575;
			color: white;
			padding: 8px 16px;
			font-size: 14px;
		}

		.btn-secondary:hover {
			background: #616161;
		}

		.empty-state {
			text-align: center;
			padding: 40px 20px;
			color: #666;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
		}

		.empty-state p {
			margin: 0;
			font-size: 16px;
		}

		.truncate {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			max-width: 120px;
		}

		.name-cell {
			font-weight: 600;
			color: #333;
		}

		.email-cell {
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
		<div class="page-header">
			<h1>Manage Enquiries</h1>
			<a href="/admin" class="btn btn-secondary">Back to Admin</a>
		</div>

		<?php if (isset($_GET['message'])): ?>
			<div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
		<?php endif; ?>

		<?php if (isset($_GET['error'])): ?>
			<div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
		<?php endif; ?>

		<div class="filter-section">
			<a href="/admin/enquiries"
				class="filter-btn <?php echo (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : ''; ?>">
				All Enquiries
			</a>
			<a href="/admin/enquiries?filter=pending"
				class="filter-btn <?php echo (isset($_GET['filter']) && $_GET['filter'] === 'pending') ? 'active' : ''; ?>">
				Pending
			</a>
			<a href="/admin/enquiries?filter=responded"
				class="filter-btn <?php echo (isset($_GET['filter']) && $_GET['filter'] === 'responded') ? 'active' : ''; ?>">
				Responded
			</a>
		</div>

		<?php if (is_array($enquiries) && count($enquiries) > 0): ?>
			<table class="enquiries-table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Name / Email</th>
						<th>Course</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($enquiries as $enquiry): ?>
						<tr>
							<td>
								<?php echo date('M d, Y', strtotime($enquiry['created_at'])); ?>
							</td>
							<td>
								<div class="name-cell"><?php echo htmlspecialchars($enquiry['name']); ?></div>
								<div class="email-cell"><?php echo htmlspecialchars($enquiry['email']); ?></div>
								<?php if (!empty($enquiry['phone'])): ?>
									<div class="email-cell"><?php echo htmlspecialchars($enquiry['phone']); ?></div>
								<?php endif; ?>
							</td>
							<td class="truncate">
								<?php echo htmlspecialchars($enquiry['course_title'] ?? 'Unknown'); ?>
							</td>
							<td>
								<?php
								$statusClass = 'status-' . strtolower($enquiry['status']);
								?>
								<span class="status-badge <?php echo $statusClass; ?>">
									<?php echo ucfirst($enquiry['status']); ?>
								</span>
							</td>
							<td>
								<div class="enquiry-actions">
									<a href="/admin/enquiries/<?php echo $enquiry['id']; ?>" class="btn btn-view">View</a>
									<?php if ($enquiry['status'] === 'new'): ?>
										<form method="POST" action="/enquiry/respond/<?php echo $enquiry['id']; ?>"
											style="display: inline;">
											<button type="submit" class="btn btn-view"
												onclick="return confirm('Mark this enquiry as responded?');">Respond</button>
										</form>
									<?php endif; ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="empty-state">
				<p>
					<?php
					if (isset($_GET['filter']) && $_GET['filter'] === 'pending') {
						echo 'No pending enquiries.';
					} elseif (isset($_GET['filter']) && $_GET['filter'] === 'responded') {
						echo 'No responded enquiries.';
					} else {
						echo 'No enquiries yet.';
					}
					?>
				</p>
			</div>
		<?php endif; ?>
	</main>

	<aside>
		<p>Manage student enquiries and track response status. All new enquiries are marked as pending and can be marked
			as responded once you have contacted the student.</p>
	</aside>

	<footer>
		&copy; 2025 University of Northampton
	</footer>

</body>

</html>