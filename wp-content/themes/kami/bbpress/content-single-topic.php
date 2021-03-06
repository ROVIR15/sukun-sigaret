<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php do_action( 'bbp_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>
        
		<div class="clearfix"></div>
        <div class="topic-title">
		  <h3><span><?php the_title(); ?></span></h3>
        </div>
        
		<?php bbp_single_topic_description(); ?>

		<?php if ( bbp_show_lead_topic() ) : ?>

			<?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

		<?php endif; ?>

		<?php if ( bbp_has_replies() ) : ?>

		<?php bbp_get_template_part( 'loop',       'replies' ); ?>
        
        <?php bbp_get_template_part( 'pagination', 'replies' ); ?>
            
		<?php bbp_topic_tag_list( 0, array(
			'before' => '<div class="bbp-topic-tags post-tags clearfix"><p><span class="post-tags-title">' . esc_html__( 'Tagged', 'bbpress' ) . '</span>&nbsp;',
			'sep'    => '',
			'after'  => '</p></div>'
		) ); ?>

		<?php endif; ?>

		<?php bbp_get_template_part( 'form', 'reply' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_topic' ); ?>

</div>
