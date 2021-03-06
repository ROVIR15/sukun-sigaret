<?php

/**
 * Single Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">

	<?php do_action( 'bbp_template_before_single_forum' ); ?>
    
    <?php bbp_breadcrumb(); ?>
            
    <?php bbp_forum_subscription_link(); ?>
	
    <?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>
        <div class="clearfix"></div>
		<div class="forum-title">
            <h3><span><?php the_title(); ?></span></h3>
            <p class="forum-description"><?php bbp_forum_content(); ?></p>
        </div>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>

		<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

			<?php bbp_get_template_part( 'loop',       'topics'    ); ?>
            
            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'form',       'topic'     ); ?>

		<?php elseif ( !bbp_is_forum_category() ) : ?>

			<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

			<?php bbp_get_template_part( 'form',       'topic'     ); ?>

		<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_forum' ); ?>

</div>
