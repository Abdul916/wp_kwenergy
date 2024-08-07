<?php
/**
 * Support Page
 *
 * @package     Wow_Pluign
 * @author      Dmytro Lobov <yoda@wow-company.com>
 * @copyright   2019 Wow-Company
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugin  = $this->plugin['name'] . ' v.' . $this->plugin['version'];
$website = get_option( 'home' );

?>

    <div class="about-wrap wow-support">
        <div class="feature-section one-col">
            <div class="col">

                <p><?php printf( esc_attr__( 'To get your support related question answered in the fastest timing, please send a message via the form below or write to us on email %1$s',
						'sticky-buttons' ), '<a href="mailto:yoda@wow-company.com">yoda@wow-company.com</a>' ); ?>
                    .</p>

                <p><?php esc_attr_e( 'Also, you can send us your ideas and suggestions for improving the plugin.',
						'sticky-buttons' ); ?></p>
				<?php $error = array();
				if ( ! empty( $_POST['action'] ) && ! empty( $_POST['wow_support_field'] ) ) {
					if ( wp_verify_nonce( $_POST['wow_support_field'], 'wow_support_action' )
					     && current_user_can( 'manage_options' )
					) {

						$fname   = ! empty( $_POST['wow-fname'] ) ? sanitize_text_field( $_POST['wow-fname'] ) : '';
						$lname   = ! empty( $_POST['wow-lname'] ) ? sanitize_text_field( $_POST['wow-lname'] ) : '';
						$message = ! empty( $_POST['wow-message'] ) ? wp_kses_post( $_POST['wow-message'] ) : '';
						$email   = ! empty( $_POST['wow-email'] ) ? sanitize_email( $_POST['wow-email'] ) : '';
						$type    = ! empty( $_POST['wow-message-type'] ) ? sanitize_text_field( $_POST['wow-message-type'] )
							: '';

						if ( empty( $fname ) ) {
							$fname = 'Anonymous';
						}
						if ( empty( $lname ) ) {
							$lname = 'Customer';
						}
						if ( empty( $message ) ) {
							$error[] = esc_attr__( 'Please, Enter your Message.', 'sticky-buttons' );
						}
						if ( empty( $email ) ) {
							$error[] = esc_attr__( 'Please, Enter your Email.', 'sticky-buttons' );
						}
						if ( count( $error ) == 0 ) {


							$headers      = array(
								'From: ' . esc_attr( $fname ) . ' ' . esc_attr( $lname ) . ' <' . sanitize_email( $email ) . '>',
								'content-type: text/html',
							);
							$message_mail = '
                                <html>
                                <head></head>
                                <body>
                                <table>
                                <tr>
                                <td><strong>Plugin:</strong></td>
                                <td>' . esc_attr( $plugin ) . '</td>
                                </tr>
                                <tr>
                                <td><strong>Website:</strong></td>
                                <td><a href="' . esc_url( $website ) . '">' . esc_url( $website ) . '</a></td>
                                </tr>
                                </table>
                                ' . nl2br( wp_kses_post( $message ) ) . '
                                </body>
                                </html>';
							wp_mail( 'yoda@wow-company.com', 'Support Ticket: ' . $type, $message_mail, $headers );
							echo '<div class="wow-alert wow-alert-update "><p class="wow_error">'
							     . esc_attr__( 'Your Message sent to the Support.', 'sticky-buttons' ) . '</p></div>';

						}


					} else {
						echo '<div class="wow-alert wow-alert-error "><p class="wow_error">'
						     . esc_attr__( 'Sorry, but message did not send. Please, contact us yoda@wow-company.com',
								'sticky-buttons' ) . ' </p></div>';
					}
				}
				?>
				<?php if ( count( $error ) > 0 ) {
					echo '<div class="wow-alert wow-alert-error "><p class="wow_error">' . implode( "<br />", $error )
					     . '</p></div>';
				} ?>


                <form method="post" action="" class="wow-plugin">
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">
									<?php esc_html_e( 'First Name', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <input type="text" class="input" name="wow-fname" value=""
                                           placeholder="<?php esc_html_e( 'Enter Your First Name', 'sticky-buttons' ); ?>">
                                </div>
                            </div>

                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">
									<?php esc_html_e( 'Last Name', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <input type="text" name="wow-lname" value="" class="input"
                                           placeholder="<?php esc_html_e( 'Enter Your Last Name', 'sticky-buttons' ); ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">
									<?php esc_html_e( 'Link to the page with issue', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <input type="text" class="input" name="wow-website"
                                           value="<?php echo esc_url( get_option( 'home' ) ); ?>">
                                </div>
                            </div>

                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">
									<?php esc_html_e( 'Contact email', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <input type="text" class="input" name="wow-email"
                                           value="<?php echo sanitize_email( get_option( 'admin_email' ) ); ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="columns">

                        <div class="column">
                            <div class="field">
                                <label class="label">
									<?php esc_html_e( 'Plugin', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <input type="text" class="input" disabled name="wow-plugin"
                                           value="<?php if ( ! empty( $name ) ) {
										       esc_attr_e( $plugin );
									       }; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">
				                    <?php esc_html_e( 'Message type', 'sticky-buttons' ); ?>
                                </label>
                                <div class="control is-expanded">
                                    <div class="select is-fullwidth">
                                        <select name="wow-message-type">
                                            <option value="Issue"><?php esc_html_e( 'Issue', 'sticky-buttons' ); ?></option>
                                            <option value="Idea"><?php esc_html_e( 'Idea', 'sticky-buttons' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <div class="control is-expanded">

									<?php
									$content   = esc_attr__( 'Enter Your Message', 'sticky-buttons' );
									$editor_id = 'editormessage';
									$settings  = array(
										'textarea_name' => 'wow-message',
									);
									wp_editor( $content, $editor_id, $settings ); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="columns">
                        <div class="column">
                            <input type="submit" class="button button-primary" name="action"
                                   value="<?php esc_html_e( 'Send to Support', 'sticky-buttons' ); ?>">
                        </div>
                    </div>
					<?php wp_nonce_field( 'wow_support_action', 'wow_support_field' ); ?>
                </form>
            </div>

        </div>
    </div>
<?php
