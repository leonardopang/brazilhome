<?php
/**
 * Checkout login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;

$registration_at_checkout = WC_Checkout::instance()->is_registration_enabled();
$login_reminder_at_checkout = 'yes' === get_option('woocommerce_enable_checkout_login_reminder');

if (is_user_logged_in()) {
    return;
}

if ($login_reminder_at_checkout): ?>
<div class="woocommerce-form-login-toggle">
    <div class="login-toggle-first">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/user-icon.png" class="user-icon-login" />
        <?php wc_print_notice(
                apply_filters('woocommerce_checkout_login_message', esc_html__('Returning customer?', 'woocommerce')) .
                '<a href="#" class="showlogin">' . esc_html__('Click here to login', 'woocommerce') . '</a> ',
                'notice'
            ); ?>

    </div>

    <button type="button" class="login-toggle-button">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-down.png" alt=""
            class="icon-toggle-button">
    </button>

</div>
<?php
endif;

if ($registration_at_checkout || $login_reminder_at_checkout):

    // Always show the form after a login attempt.
    $show_form = isset($_POST['login']); // phpcs:ignore WordPress.Security.NonceVerification.Missing
    ?>

<div class="brazil-checkout-login-container">
    <form class="brazil-checkout-login-form woocommerce-form woocommerce-form-login login" method="post"
        <?php echo (!$show_form) ? 'style="display:none;"' : ''; ?>>

        <p class="brazil-login-description">Se você já comprou conosco antes, insira seus dados abaixo.</p>

        <div class="brazil-login-inputs-row">
            <div class="brazil-login-field-group brazil-login-field-username">
                <label for="username"
                    class="brazil-login-field-label"><?php esc_html_e('Endereço de e-mail', 'woocommerce'); ?>&nbsp;<span
                        class="brazil-login-required">*</span></label>
                <input type="text"
                    class="brazil-login-input brazil-login-username woocommerce-Input woocommerce-Input--text input-text"
                    name="username" id="username" autocomplete="username"
                    value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>
            <div class="brazil-login-field-group brazil-login-field-password">
                <label for="password"
                    class="brazil-login-field-label"><?php esc_html_e('Senha', 'woocommerce'); ?>&nbsp;<span
                        class="brazil-login-required">*</span></label>
                <input
                    class="brazil-login-input brazil-login-password woocommerce-Input woocommerce-Input--text input-text"
                    type="password" name="password" id="password" autocomplete="current-password" />
            </div>
            <div class="brazil-login-submit-wrapper">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit"
                    class="brazil-login-submit-btn woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                    name="login"
                    value="<?php esc_attr_e('ENTRAR', 'woocommerce'); ?>"><?php esc_html_e('ENTRAR', 'woocommerce'); ?></button>
            </div>
        </div>

        <div class="brazil-login-footer">
            <div class="brazil-login-footer-row">
                <div class="brazil-login-remember-wrapper">
                    <label
                        class="brazil-login-checkbox-label woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="brazil-login-checkbox woocommerce-form__input woocommerce-form__input-checkbox"
                            name="rememberme" type="checkbox" id="rememberme" value="forever" />
                        <span
                            class="brazil-login-checkbox-text"><?php esc_html_e('Lembrar senha', 'woocommerce'); ?></span>
                    </label>
                </div>
                <div class="brazil-login-forgot-wrapper">
                    <a class="brazil-login-forgot-link"
                        href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Esqueci minha senha', 'woocommerce'); ?></a>
                </div>
                <div></div>
            </div>

        </div>

        <div class="brazil-login-errors">
            <?php do_action('woocommerce_login_form_start'); ?>
            <?php do_action('woocommerce_login_form_end'); ?>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginToggleButton = document.querySelector('.login-toggle-button');
    const loginContainer = document.querySelector('.brazil-checkout-login-container');
    const toggleIcon = document.querySelector('.icon-toggle-button');

    if (loginToggleButton && loginContainer) {
        // Initially hide the login container
        loginContainer.style.display = 'none';

        loginToggleButton.addEventListener('click', function() {
            if (loginContainer.style.display === 'none') {
                loginContainer.style.display = 'flex';
                // Rotate arrow icon down
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            } else {
                loginContainer.style.display = 'none';
                // Rotate arrow icon up
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            }
        });
    }

    // Also handle the existing showlogin link functionality
    const showloginLink = document.querySelector('.showlogin');
    if (showloginLink && loginContainer) {
        showloginLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (loginContainer.style.display === 'none') {
                loginContainer.style.display = 'flex';
                // Rotate arrow icon down
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            } else {
                loginContainer.style.display = 'none';
                // Rotate arrow icon up  
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            }
        });
    }

    // Change username label text to email using CSS selector
    const usernameLabel = document.querySelector('#customer_login > div.u-column1.col-1 > form > p:nth-child(1) > label');
    if (usernameLabel) {
        // Replace the text content while preserving the required asterisk and screen reader text
        const requiredSpan = usernameLabel.querySelector('.required, span[aria-hidden="true"]');
        const screenReaderSpan = usernameLabel.querySelector('.screen-reader-text');

        // Clear the label content but keep the spans
        usernameLabel.innerHTML = 'Endereço de e-mail&nbsp;';

        // Re-add the required and screen reader spans
        if (requiredSpan) {
            usernameLabel.appendChild(requiredSpan);
        }
        if (screenReaderSpan) {
            usernameLabel.appendChild(screenReaderSpan);
        }

        // If spans don't exist, create them
        if (!requiredSpan) {
            const newRequiredSpan = document.createElement('span');
            newRequiredSpan.className = 'required';
            newRequiredSpan.setAttribute('aria-hidden', 'true');
            newRequiredSpan.textContent = '*';
            usernameLabel.appendChild(newRequiredSpan);
        }

        if (!screenReaderSpan) {
            const newScreenReaderSpan = document.createElement('span');
            newScreenReaderSpan.className = 'screen-reader-text';
            newScreenReaderSpan.textContent = 'Obrigatório';
            usernameLabel.appendChild(newScreenReaderSpan);
        }
    }
});
</script>

<?php
endif;