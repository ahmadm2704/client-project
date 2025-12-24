<!doctype html>
<html>
	<head>
		<title>Staff Login - University of Northampton</title>
		<link rel="stylesheet" href="/uon.css?v=2" />
		<style>
			main {
				display: flex;
				justify-content: center;
				align-items: flex-start;
				padding: 40px 20px;
			}
			.login-container {
				width: 100%;
				max-width: 400px;
				background: white;
				padding: 45px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.08);
				box-sizing: border-box;
				overflow: hidden;
			}
			.login-container form {
				width: 100%;
			}
			.login-container h1 {
				color: #333;
				margin: 0 0 35px 0;
				text-align: center;
				font-size: 28px;
				font-weight: 700;
			}
			.form-group {
				margin-bottom: 22px;
				width: 100%;
				display: block;
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
				max-width: 100%;
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
			.btn-login {
				width: 100%;
				padding: 13px;
				background: #1976d2;
				color: white;
				border: none;
				border-radius: 4px;
				font-size: 16px;
				font-weight: 700;
				cursor: pointer;
				transition: background 0.3s;
				margin-top: 15px;
			}
			.btn-login:hover {
				background: #1565c0;
			}
			.btn-login:active {
				transform: translateY(1px);
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
			<div class="login-container">
				<h1>Staff Login</h1>
				
				<?php if (isset($_GET['message']) && $_GET['message'] === 'logged_out'): ?>
					<div class="alert alert-success">You have been logged out successfully</div>
				<?php endif; ?>
				
				<?php if ($error): ?>
					<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
				<?php endif; ?>

				<form method="POST">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" id="username" name="username" required autofocus />
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" id="password" name="password" required />
					</div>

					<button type="submit" class="btn-login">Log In</button>
				</form>
			</div>
		</main>

		<aside>
            <p>Staff members can log in here to access the administration dashboard where they can manage courses, subject areas, and student enquiries.</p>
		</aside>

		<footer>
			&copy; 2025 University of Northampton
		</footer>

	</body>

</html>


