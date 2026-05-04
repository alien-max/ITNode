<?php
if ( !defined( 'ABSPATH' ) ) { exit; }
if ( !post_type_supports( get_post_type(), 'comments' ) ) { return; }
if ( !have_comments() && !comments_open() ) { return; }
?>

<section id="comments" class="comments-area">
	<?php if ( have_comments() ) { ?>
		<h3 class="title-comments">
			<?php
			$comments_number = get_comments_number();
			echo esc_html( $comments_number );
			if ( '1' === $comments_number ) {
				echo esc_html( ' Response' );
			} else {
				echo esc_html( ' Responses' );
			} ?>
		</h3>
		<?php the_comments_navigation(); ?>
		<ol class="comment-list">
			<?php wp_list_comments(['style' => 'ol', 'short_ping' => true, 'avatar_size' => 42]); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php }
	comment_form(['title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">', 'title_reply_after'  => '</h2>']); ?>
</section>