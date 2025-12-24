<!doctype html>
<html>
	<head>
		<title>Enquiry Details - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			* {
				box-sizing: border-box;
			}

			body {
				display: flex;
				flex-direction: column;
				min-height: 100vh;
			}

			main {
				flex: 1;
				display: flex;
				justify-content: center;
				padding: 40px 20px;
				background: #f8f9fa;
			}

			.container {
				width: 100%;
				max-width: 600px;
				box-sizing: border-box;
			}

			.page-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 30px;
			}

			.page-header h1 {
				margin: 0;
				color: #333;
				font-size: 28px;
				font-weight: 700;
			}

			.detail-card {
				background: white;
				padding: 30px;
				border-radius: 12px;
				box-shadow: 0 2px 16px rgba(0,0,0,0.06);
				border: 1px solid #f0f0f0;
				margin-bottom: 20px;
				box-sizing: border-box;
				width: 100%;
			}

			.detail-row {
				margin-bottom: 25px;
				padding-bottom: 25px;
				border-bottom: 1px solid #e0e0e0;
			}

			.detail-row:last-child {
				margin-bottom: 0;
				padding-bottom: 0;
				border-bottom: none;
			}

			.detail-label {
				font-size: 12px;
				font-weight: 700;
				color: #666;
				text-transform: uppercase;
				letter-spacing: 0.5px;
				margin-bottom: 6px;
			}

			.detail-value {
				font-size: 16px;
				color: #333;
				line-height: 1.6;
				word-wrap: break-word;
			}

			.status-badge {
				display: inline-block;
				padding: 6px 16px;
				border-radius: 20px;
				font-size: 13px;
				font-weight: 600;
				white-space: nowrap;
			}

			.status-new {
				background: #fff3cd;
				color: #856404;
			}

			.status-responded {
				background: #d4edda;
				color: #155724;
			}

			.status-closed {
				background: #e2e3e5;
				color: #383d41;
			}

			.message-box {
				background: #f8f9fa;
				padding: 16px;
				border-radius: 8px;
				border-left: 4px solid #1976d2;
				white-space: pre-wrap;
				word-wrap: break-word;
			}

			.action-buttons {
				display: flex;
				gap: 10px;
				margin-top: 30px;
				padding-top: 30px;
				border-top: 1px solid #e0e0e0;
			}

			.btn {
				padding: 10px 20px;
				border: none;
				border-radius: 8px;
				cursor: pointer;
				font-size: 15px;
				font-weight: 600;
				transition: all 0.3s ease;
				text-decoration: none;
				display: inline-block;
			}

			.btn-primary {
				background: #1976d2;
				color: white;
				flex: 1;
			}

			.btn-primary:hover {
				background: #1565c0;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
			}

			.btn-danger {
				background: #d32f2f;
				color: white;
			}

			.btn-danger:hover {
				background: #c62828;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
			}

			.btn-secondary {
				background: #757575;
				color: white;
				text-decoration: none;
			}

			.btn-secondary:hover {
				background: #616161;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(117, 117, 117, 0.3);
			}

			aside {
				background: #f5f5f5;
				padding: 50px 20px;
				text-align: center;
				border-top: 1px solid #e0e0e0;
				width: 100%;
			}

			aside p {
				max-width: 600px;
				margin: 0 auto;
				color: #555;
				font-size: 16px;
				line-height: 1.7;
				font-weight: 500;
			}

			footer {
				background: #333;
				color: white;
				text-align: center;
				padding: 20px;
				font-size: 14px;
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
				<div class="page-header">
					<h1>Enquiry Details</h1>
					<a href="/admin/enquiries" class="btn btn-secondary">Back to List</a>
				</div>

				<div class="detail-card">
					<div class="detail-row">
						<div class="detail-label">Full Name</div>
						<div class="detail-value">
							<?php echo htmlspecialchars($enquiry['name'] ?? 'N/A'); ?>
						</div>
					</div>

					<div class="detail-row">
						<div class="detail-label">Email Address</div>
						<div class="detail-value">
							<a href="mailto:<?php echo htmlspecialchars($enquiry['email'] ?? ''); ?>" style="color: #1976d2; text-decoration: none;">
								<?php echo htmlspecialchars($enquiry['email'] ?? 'N/A'); ?>
							</a>
						</div>
					</div>

					<?php if (!empty($enquiry['phone'])): ?>
						<div class="detail-row">
							<div class="detail-label">Phone Number</div>
							<div class="detail-value">
								<a href="tel:<?php echo htmlspecialchars($enquiry['phone']); ?>" style="color: #1976d2; text-decoration: none;">
									<?php echo htmlspecialchars($enquiry['phone']); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>

					<div class="detail-row">
						<div class="detail-label">Course</div>
						<div class="detail-value">
							<?php echo htmlspecialchars($enquiry['course_title'] ?? 'Unknown'); ?>
						</div>
					</div>

					<div class="detail-row">
						<div class="detail-label">Enquiry Message</div>
						<div class="message-box">
							<?php echo htmlspecialchars($enquiry['message'] ?? ''); ?>
						</div>
					</div>

					<div class="detail-row">
						<div class="detail-label">Status</div>
						<div>
							<?php 
								$statusClass = 'status-' . strtolower($enquiry['status']);
								$statusLabel = ucfirst($enquiry['status']);
							?>
							<span class="status-badge <?php echo $statusClass; ?>">
								<?php echo $statusLabel; ?>
							</span>
						</div>
					</div>

					<div class="detail-row">
						<div class="detail-label">Submitted On</div>
						<div class="detail-value">
							<?php echo date('M d, Y at H:i', strtotime($enquiry['created_at'])); ?>
						</div>
					</div>

					<?php if (!empty($enquiry['responded_by']) && $enquiry['status'] === 'responded'): ?>
						<div class="detail-row">
							<div class="detail-label">Responded By</div>
							<div class="detail-value">
								<?php echo htmlspecialchars($enquiry['responder_name'] ?? 'Unknown'); ?>
							</div>
						</div>

						<div class="detail-row">
							<div class="detail-label">Response Date</div>
							<div class="detail-value">
								<?php echo date('M d, Y at H:i', strtotime($enquiry['responded_at'])); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="action-buttons">
						<?php if ($enquiry['status'] === 'new'): ?>
							<form method="POST" action="/enquiry/respond/<?php echo $enquiry['id']; ?>" style="flex: 1;">
								<button type="submit" class="btn btn-primary" style="width: 100%;" onclick="return confirm('Mark this enquiry as responded?');">Mark as Responded</button>
							</form>
						<?php endif; ?>
						<form method="POST" action="/enquiry/delete/<?php echo $enquiry['id']; ?>" style="display: inline;">
							<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this enquiry?');">Delete</button>
						</form>
					</div>
				</div>
			</div>
		</main>

		<aside>
            <p>Review enquiry details and mark as responded once you have contacted the student.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

