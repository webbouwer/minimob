<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}



// Arguments for the query
$args = array();

// The comment query
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );

// The comment loop
if ( !empty( $comments ) ) {
    echo '<ul>';
    foreach ( $comments as $comment ) {
        //comment_author
        //comment_content
        //comment_date / comment_date_gmt
        echo '<li class="comment">';
            echo '<div class="message">'. $comment->comment_content .'</div>';
            echo '<div class="author">'. $comment->comment_author.'</div>';
            echo '<div class="time">';
            echo wp_time_ago( strtotime($comment->comment_date) );
            echo '</div>';
        echo '</li>';
        //print_r($comment);
    }
    echo '</ul>';
} else {
    echo 'No comments found.';
}

// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>

<?php endif;

comment_form();


/*

function minimob_under_comments($comment, $args, $depth) {

$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>

<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="row">
  <div class="small-3 columns">
      <div class="gravatar-container">
          <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
      </div><!-- .comment-meta -->
  </div>
  <div class="small-9 columns">    <div class="comment-meta">

                    <div class="comment-author">

                        <?php printf( __( '%s' ), sprintf( '<span class="commenter">%s</span>', get_comment_author_link() ) ); ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                            </time>
                        </a>
                     </div><!-- .comment-metadata -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->
                   <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->
  </div>

</div>

  <div class="small-12 columns">

                <?php
                comment_reply_link( array_merge( $args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>'
                ) ) );
                ?>

      </div>
</article><!-- .comment-body -->
<?php
}


?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : /* ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					/* translators: %s: post title
					printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'twentyfifteen' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title
						_nx(
							'%1$s thought on &ldquo;%2$s&rdquo;',
							'%1$s thoughts on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'minimob'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>

		<?php //twentyfifteen_comment_nav();

            wp_list_comments( array(
                'callback' => minimob_under_comments,
            ) );


				wp_list_comments( array(
					'style'       => 'ul',
					'type'  => 'comment',
					//'avatar_size' => 56,
				) );
			?>
		<!-- .comment-list -->

		<?php //twentyfifteen_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
    <br /><br />
</div><!-- .comments-area -->
*/
?>
