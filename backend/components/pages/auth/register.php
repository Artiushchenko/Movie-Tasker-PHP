<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<style>
	@import '../../../styles/pages/auth/register.css';
</style>

<section class="auth">
        <div class="auth-banner">
            <img src="../../../assets/images/register_photo.png" alt="Registration Banner">
        </div>

        <div class="auth-form">
            <span>Registration</span>

            <form action="../../../handlers/register.php" method="POST">
	            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']) ?>" />

	            <div class="input-container">
                    <input
                        type="email"
                        name="email"
                        placeholder="E-mail"
                        class="input-field"
                        required
                    />
                    <?php if (isset($_SESSION['errors']['email'])): ?>
		                <p class="error-message">
			                <?php
			                echo htmlspecialchars($_SESSION['errors']['email']);
							?>
		                </p>
                    <?php endif; ?>
                </div>

                <div class="input-container">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="input-field"
                        required
                    />
                    <?php if (isset($_SESSION['errors']['password'])): ?>
		                <p class="error-message">
			                <?php
			                echo htmlspecialchars($_SESSION['errors']['password']);
							?>
		                </p>
                    <?php endif; ?>
                </div>

                <div class="input-container">
                    <input
                        type="password"
                        name="confirm_password"
                        placeholder="Confirm password"
                        class="input-field"
                        required
                    />
                    <?php if (isset($_SESSION['errors']['confirm_password'])): ?>
		                <p class="error-message">
			                <?php
			                echo htmlspecialchars($_SESSION['errors']['confirm_password']);
							?>
		                </p>
                    <?php endif; ?>
                </div>

	            <button type="submit">Register</button>
            </form>

            <?php if (isset($_SESSION['errors']['general'])): ?>
		        <p class="submitStatus">
                    <?php echo $_SESSION['errors']['general']; ?>
		        </p>
            <?php endif; ?>

            <div class="navigate">
                <span>Do you have an account?</span>
                <a href="/login">Log In</a>
            </div>
        </div>
    </section>
