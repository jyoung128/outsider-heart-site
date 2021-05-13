<?php require_once "include/header.php" ?>

<main>
<?php if (count($model->errors) > 0): ?>
		<ul class="errors">
			<?php foreach ($model->errors as $error): ?>
				<li><?=$error?></li>
			<?php endforeach; ?>
		</ul>
<?php endif; ?>

<form action="" method="post">
	<fieldset>
		<legend>Reset Password</legend>
        <div class="input-row">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username">
		</div>
		<div class="input-row">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password">
		</div>
		<div class="input-row">
			<label for="confirm">Confirm password:</label>
			<input type="password" name="confirm" id="confirm">
		</div>
		<div class="input-row">
			<button type="submit">Reset</button>
		</div>
	</fieldset>
	</form>
</main>

<?php require_once "include/footer.php" ?>