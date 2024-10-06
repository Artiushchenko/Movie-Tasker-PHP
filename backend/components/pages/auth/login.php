<?php
	require_once __DIR__ . '/../../ui/button/button.php';
?>

<section class="auth">
    <div class="auth-banner">
        <img src="../../../assets/images/login_photo.jpg" alt="Login Banner">
    </div>

    <div class="auth-form">
        <span>Log In</span>

        <form action="../../../handlers/login.php" method="POST">
            <div class="input-container">
                <input
                    type="email"
                    name="email"
                    placeholder="E-mail"
                    class="input-field"
                    required
                    value="
                        <?php
                            echo isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : '';
                        ?>
					"
                />
            </div>

            <div class="input-container">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="input-field"
                    required
                />
            </div>

	        <div>
		        <label for="remember">
			        <input
			            id="remember"
				        type="checkbox"
			            name="remember"
			            <?php
			                echo isset($_COOKIE['remember_email']) ? 'checked' : '';
			            ?>
			        >
			        Remember me
		        </label>
	        </div>

	        <?php
	            renderButton('Log in', 'submit');
	        ?>
        </form>

        <div class="navigate">
            <span>Don't have an account yet?</span>
            <a href="/register">Sign In</a>
        </div>
    </div>
</section>
