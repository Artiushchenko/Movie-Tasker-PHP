<?php
	require_once __DIR__ . '/../../ui/button/button.php';
?>

<section class="auth">
        <div class="auth-banner">
            <img src="../../../assets/images/register_photo.png" alt="Registration Banner">
        </div>

        <div class="auth-form">
            <span>Registration</span>

            <form action="../../../handlers/register.php" method="POST">
                <div class="input-container">
                    <input
                        type="email"
                        name="email"
                        placeholder="E-mail"
                        class="input-field"
                        required
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

                <div class="input-container">
                    <input
                        type="password"
                        name="confirm_password"
                        placeholder="Confirm password"
                        class="input-field"
                        required
                    />
                </div>

                <?php
                    renderButton('Register', 'submit');
                ?>
            </form>

            <div class="navigate">
                <span>Do you have an account?</span>
                <a href="/login">Log In</a>
            </div>
        </div>
    </section>
