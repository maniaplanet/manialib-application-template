<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"> 
	<head>
		<title>Oops</title>
	</head>
	<body>
		<h1>Oops! Something went wrong, please try again later.</h1>
		<?php if(isset($message)): ?>
			<pre><?php echo htmlentities($message, ENT_QUOTES, 'UTF-8'); ?></pre>
		<?php endif; ?>
	</body>
</html>
