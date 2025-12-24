<!doctype html>
<html>
	<head>
		<title>Delete Staff Member - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			.confirm-container {
				max-width: 450px;
				background: white;
				padding: 45px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.08);
				text-align: center;
			}
			.confirm-container h2 {
				color: #d32f2f;
				margin: 0 0 20px 0;
				font-size: 24px;
				font-weight: 700;
			}
			.confirm-container p {
				font-size: 16px;
				color: #666;
				margin: 15px 0;
				line-height: 1.6;
			}
			.username-highlight {
				font-weight: 700;
				color: #333;
				font-size: 18px;
			}
			.form-actions {
				display: flex;
				gap: 12px;
				margin-top: 35px;
			}
			.btn-confirm {
				flex: 1;
				padding: 12px;
				background: #d32f2f;
				color: white;
				border: none;
				border-radius: 4px;
				font-size: 16px;
				font-weight: 700;
				cursor: pointer;
				transition: background 0.3s;
			}
			.btn-confirm:hover {
				background: #b71c1c;
			}
			.btn-cancel {
				flex: 1;
				padding: 12px;
				background: #757575;
				color: white;
				border: none;
				border-radius: 4px;
				font-size: 16px;
				font-weight: 700;
				cursor: pointer;
				text-decoration: none;
				display: flex;
				align-items: center;
				justify-content: center;
				transition: background 0.3s;
			}
			.btn-cancel:hover {
				background: #616161;
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
			<div class="confirm-container">
				<?php if ($error): ?>
					<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
					<a href="/users" class="btn-cancel" style="display: inline-block; width: auto;">Back to Staff</a>
				<?php else: ?>
					<h2>Delete Staff Member?</h2>
					<p>Are you sure you want to permanently delete this account?</p>
					<p><span class="username-highlight"><?php echo htmlspecialchars($user['username']); ?></span></p>
					<p style="color: #888; font-size: 14px;">This action cannot be undone.</p>

					<form method="POST" action="/users/delete?id=<?php echo $user['id']; ?>">
						<div class="form-actions">
							<button type="submit" class="btn-confirm">Delete Account</button>
							<a href="/users" class="btn-cancel">Cancel</a>
						</div>
					</form>
				<?php endif; ?>
			</div>
		</main>

		<aside>
			<p>This action is permanent. Deleted accounts cannot be recovered.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>

