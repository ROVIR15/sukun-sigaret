<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics">

	<li class="bbp-header">

		<ul class="forum-titles">
			<li class="bbp-topic-title bk-forum-header-font"><?php _e( 'Topic', 'bbpress' ); ?></li>
			<li class="bbp-topic-voice-count bk-forum-header-font"><?php _e( 'Voices', 'bbpress' ); ?></li>
			<li class="bbp-topic-reply-count bk-forum-header-font"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></li>
			<li class="bbp-topic-freshness bk-forum-header-font"><?php _e( 'Freshness', 'bbpress' ); ?></li>
		</ul>

	</li>

	<li class="bbp-body bk-forum-loop">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
