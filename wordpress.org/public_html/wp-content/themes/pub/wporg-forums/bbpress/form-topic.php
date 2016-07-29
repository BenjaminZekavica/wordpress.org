<?php if ( !bbp_is_single_forum() ) : ?>

<div id="bbpress-forums">

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>

	<div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">

		<form id="new-post" name="new-post" method="post" action="">

			<?php do_action( 'bbp_theme_before_topic_form' ); ?>

			<fieldset class="bbp-form">
				<legend>

					<?php
						if ( bbp_is_topic_edit() )
							printf( __( 'Now Editing &ldquo;%s&rdquo;', 'wporg-forums' ), bbp_get_topic_title() );
						else
							bbp_is_single_forum() ? printf( __( 'Create New Topic in &ldquo;%s&rdquo;', 'wporg-forums' ), bbp_get_forum_title() ) : _e( 'Create New Topic', 'wporg-forums' );
					?>

				</legend>

				<?php do_action( 'bbp_theme_before_topic_form_notices' ); ?>

				<?php if ( ! bbp_is_topic_edit() && ! bbp_is_forum_closed() ) : ?>

					<div class="bbp-template-notice">
						<p><?php
							printf(
								/* translators: %s: Search URL */
								__( 'Before posting a new topic, be sure to <a href="%s">search</a> to see if one has been started already.', 'wporg-forums' ),
								esc_url( bbp_get_search_url() )
							);
						?></p>
						<p><?php _e( 'Having a problem? Asking a question? Make sure to read the <a href="http://codex.wordpress.org/Forum_Welcome">Forum Welcome</a> to find out how to maximize your odds of getting help!', 'wporg-forums' ); ?></p>
					</div>

				<?php endif; ?>

				<?php if ( !bbp_is_topic_edit() && bbp_is_forum_closed() ) : ?>

					<div class="bbp-template-notice">
						<p><?php _e( 'This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'wporg-forums' ); ?></p>
					</div>

				<?php endif; ?>

				<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

					<div class="bbp-template-notice">
						<p><?php _e( 'Your account has the ability to post unrestricted HTML content.', 'wporg-forums' ); ?></p>
					</div>

				<?php endif; ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<div>

					<?php bbp_get_template_part( 'form', 'anonymous' ); ?>

					<?php do_action( 'bbp_theme_before_topic_form_title' ); ?>

					<p>
						<label for="bbp_topic_title"><?php printf( __( 'Topic Title (Maximum Length: %d):', 'wporg-forums' ), bbp_get_title_max_length() ); ?></label><br />
						<input type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" />
					</p>

					<?php do_action( 'bbp_theme_after_topic_form_title' ); ?>

					<?php do_action( 'bbp_theme_before_topic_form_content' ); ?>

					<?php if ( !function_exists( 'wp_editor' ) ) : ?>

						<p>
							<label for="bbp_reply_content"><?php _e( 'Reply:', 'wporg-forums' ); ?></label><br />
							<textarea id="bbp_topic_content" tabindex="<?php bbp_tab_index(); ?>" name="bbp_topic_content" cols="60" rows="6"><?php bbp_form_topic_content(); ?></textarea>
						</p>

					<?php else : ?>

						<?php bbp_the_content( array( 'context' => 'topic' ) ); ?>

					<?php endif; ?>

					<?php do_action( 'bbp_theme_after_topic_form_content' ); ?>

					<?php do_action( 'bbp_theme_before_topic_form_tags' ); ?>

					<p>
						<label for="bbp_topic_tags"><?php _e( 'Topic Tags:', 'wporg-forums' ); ?></label><br />
						<input type="text" value="<?php bbp_form_topic_tags(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
					</p>

					<?php do_action( 'bbp_theme_after_topic_form_tags' ); ?>

					<?php if ( !bbp_is_single_forum() ) : ?>

						<?php do_action( 'bbp_theme_before_topic_form_forum' ); ?>

						<p>
							<label for="bbp_forum_id"><?php _e( 'Forum:', 'wporg-forums' ); ?></label><br />
							<?php bbp_dropdown( array( 'selected' => bbp_get_form_topic_forum() ) ); ?>
						</p>

						<?php do_action( 'bbp_theme_after_topic_form_forum' ); ?>

					<?php endif; ?>

					<?php if ( current_user_can( 'moderate' ) ) : ?>

						<?php do_action( 'bbp_theme_before_topic_form_type' ); ?>

						<p>

							<label for="bbp_stick_topic"><?php _e( 'Topic Type:', 'wporg-forums' ); ?></label><br />

							<?php bbp_topic_type_select(); ?>

						</p>

						<?php do_action( 'bbp_theme_after_topic_form_type' ); ?>

					<?php endif; ?>

					<?php if ( bbp_is_subscriptions_active() && !bbp_is_anonymous() && ( !bbp_is_topic_edit() || ( bbp_is_topic_edit() && !bbp_is_topic_anonymous() ) ) ) : ?>

						<?php do_action( 'bbp_theme_before_topic_form_subscriptions' ); ?>

						<p>
							<input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> tabindex="<?php bbp_tab_index(); ?>" />

							<?php if ( bbp_is_topic_edit() && ( get_the_author_meta( 'ID' ) != bbp_get_current_user_id() ) ) : ?>

								<label for="bbp_topic_subscription"><?php _e( 'Notify the author of follow-up replies via email', 'wporg-forums' ); ?></label>

							<?php else : ?>

								<label for="bbp_topic_subscription"><?php _e( 'Notify me of follow-up replies via email', 'wporg-forums' ); ?></label>

							<?php endif; ?>
						</p>

						<?php do_action( 'bbp_theme_after_topic_form_subscriptions' ); ?>

					<?php endif; ?>

					<?php if ( bbp_allow_revisions() && bbp_is_topic_edit() ) : ?>

						<?php do_action( 'bbp_theme_before_topic_form_revisions' ); ?>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Revision', 'wporg-forums' ); ?></legend>
							<div>
								<input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" <?php bbp_form_topic_log_edit(); ?> tabindex="<?php bbp_tab_index(); ?>" />
								<label for="bbp_log_topic_edit"><?php _e( 'Keep a log of this edit:', 'wporg-forums' ); ?></label><br />
							</div>

							<div>
								<label for="bbp_topic_edit_reason"><?php printf( __( 'Optional reason for editing:', 'wporg-forums' ), bbp_get_current_user_name() ); ?></label><br />
								<input type="text" value="<?php bbp_form_topic_edit_reason(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_edit_reason" id="bbp_topic_edit_reason" />
							</div>
						</fieldset>

						<?php do_action( 'bbp_theme_after_topic_form_revisions' ); ?>

					<?php endif; ?>

					<?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>

					<div class="bbp-submit-wrapper">

						<?php do_action( 'bbp_theme_before_topic_form_submit_button' ); ?>

						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_topic_submit" name="bbp_topic_submit" class="button submit"><?php _e( 'Submit', 'wporg-forums' ); ?></button>

						<?php do_action( 'bbp_theme_after_topic_form_submit_button' ); ?>

					</div>

					<?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>

				</div>

				<?php bbp_topic_form_fields(); ?>

			</fieldset>

			<?php do_action( 'bbp_theme_after_topic_form' ); ?>

		</form>
	</div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

	<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
		<div class="bbp-template-notice">
			<p><?php printf( __( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'wporg-forums' ), bbp_get_forum_title() ); ?></p>
		</div>
	</div>

<?php else : ?>

	<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
		<div class="bbp-template-notice">
			<p><?php is_user_logged_in() ? _e( 'You cannot create new topics at this time.', 'wporg-forums' ) : _e( 'You must be logged in to create new topics.', 'wporg-forums' ); ?></p>
		</div>
	</div>

<?php endif; ?>

<?php if ( !bbp_is_single_forum() ) : ?>

</div>

<?php endif; ?>
