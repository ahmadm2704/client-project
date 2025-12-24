<!doctype html>
<html>

<head>
	<title>Make an Enquiry - University of Northampton</title>
	<link rel="stylesheet" href="/uon.css?v=2" />
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
		<h1>Make an enquiry</h1>

		<?php if (isset($_GET['message'])): ?>
			<p style="color: green; margin-bottom: 1em;"><?php echo htmlspecialchars($_GET['message']); ?></p>
		<?php endif; ?>

		<?php if (isset($error) && !empty($error)): ?>
			<p style="color: red; margin-bottom: 1em;"><?php echo $error; ?></p>
		<?php endif; ?>

		<form method="POST" action="/enquiry/save">
			<label for="name">Your name <span style="color: red;">*</span></label>
			<input type="text" id="name" name="name" required maxlength="150"
				value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />

			<label for="email">Email address <span style="color: red;">*</span></label>
			<input type="email" id="email" name="email" required maxlength="120"
				value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />

			<label for="phone">Phone number</label>
			<input type="tel" id="phone" name="phone" maxlength="20"
				value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" />

			<label for="course_id">Which course are you enquiring about? <span style="color: red;">*</span></label>
			<select id="course_id" name="course_id" required>
				<option value="">-- Select a course --</option>
				<?php if (isset($courses) && is_array($courses)): ?>
					<?php foreach ($courses as $course): ?>
						<option value="<?php echo $course['id']; ?>" <?php echo (isset($_POST['course_id']) && $_POST['course_id'] == $course['id']) ? 'selected' : ''; ?>>
							<?php echo htmlspecialchars($course['title']); ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<label for="message">What do you want to ask? <span style="color: red;">*</span></label>
			<textarea id="message" name="message"
				required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>

			<input type="submit" value="Submit Enquiry" />
		</form>
	</main>

	<aside>
		<p>We'll support you every step of the way whichever course you choose – providing you with first–class
			teaching, modern facilities, impressive accommodation and great learning. We have increased focus on
			seminars or tutorials that allow closer interaction between students and a member of staff in the form of
			discussion in small groups or one-to-one that mimic practice in the professional world, allowing for
			experimentation, ideas, and teamwork.</p>

		Applications for 2026 are now open. <a href="/">Find your course now.</a>
	</aside>

	<footer>
		&copy; 2025 University of Northampton
	</footer>

</body>

</html>
