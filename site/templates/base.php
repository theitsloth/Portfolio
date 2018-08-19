<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Lorinc Bethlenfalvy</title>

		<!-- External resources -->
		<script src="static/js/jquery-3.3.1.min.js"></script>

		<!-- Loading js/css-->
		<link rel="stylesheet" type="text/css"
			href="static/css/main.css" />
		<script src="static/js/main.js"></script>
		<?php block("head"); ?>
	</head>
	<body>
		<div id="side">
			<img src="http://api.adorable.io/avatars/lorinc"
				id="avatar" />
			<div id="intro">
				Lőrinc Bethlenfalvy <br> programmer,
				SA.
			</div>
			<div id="menu">
				<a class="menuitem" href="/">Home</a>
				<a class="menuitem" href="/about">About</a>
				<a class="menuitem" href="/projects">Projects</a>
			</div>
		</div>
		<div id="main">
			<?php if(isblock("right")): ?>
			<div id='rightside'>
				<?php block("right"); ?>
			</div>
			<?php endif; ?>
			<div id="content"
			class=" <?= isblock("right")?
			'contentwithright' : '' ?>">
				<?php block("content"); ?>
			</div>
			<div id="footer">
				<a href="mailto:lorinc11@gmail.com">
					lorinc11@gmail.com
				</a>
			</div>
		</div>
	</body>
</html>
