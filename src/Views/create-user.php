<!doctype html>
<html>

<head>
	<title>Add Staff Member - University of Northampton</title>
	<link rel="stylesheet" href="/uon.css?v=2" />
	<style>
		.form-container {
			width: 100%;
			max-width: 100%;
			background: white;
			padding: 25px;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			box-sizing: border-box;
		}

		.form-container h2 {
			color: #333;
			margin: 0 0 25px 0;
			font-size: 24px;
			font-weight: 700;
		}

		.form-group {
			margin-bottom: 20px;
			width: 100%;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #333;
			font-size: 14px;
		}

		.form-group input {
			display: block;
			width: 100%;
			max-width: 350px;
			padding: 12px 14px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			box-sizing: border-box;
		}

		.form-group input:focus {
			outline: none;
			border-color: #1976d2;
			box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
		}

		.form-actions {
			display: flex;
			gap: 12px;
			margin-top: 25px;
		}

		.btn-submit {
			background: #1976d2;
			color: white;
			padding: 12px 24px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
		}

		.btn-submit:hover {
			background: #1565c0;
		}

		.btn-cancel {
			background: #757575;
			color: white;
			padding: 12px 24px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			font-weight: 600;
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

		.password-help {
			font-size: 12px;
			color: #666;
			margin-top: 5px;
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
		<div class="form-container">
			<h2>Add New Staff Member</h2>

			<?php if (isset($error) && $error): ?>
				<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
			<?php endif; ?>

			<form method="POST">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" required autocomplete="off" />
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" required />
					<div class="password-help">Must be at least 6 characters</div>
				</div>

				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" id="confirm_password" name="confirm_password" required />
				</div>

				<div class="form-actions">
					<button type="submit" class="btn-submit">Create Account</button>
					<a href="/users" class="btn-cancel">Cancel</a>
				</div>
			</form>
		</div>
	</main>

	<aside>
		<p>Staff members can log in and access the admin dashboard to manage courses and enquiries.</p>
	</aside>

	<footer>
		&copy; 2025 University of Northampton
	</footer>

</body>

</html>