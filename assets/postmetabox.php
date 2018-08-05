<?php /* POST META BOXES*/
function add_custom_link_box()
{
	/* POST CUSTOM LINK META FIELDS */
    add_meta_box(
        "post-custom-link-box",
        "Custom Link",
        "post_meta_link_fields",
        array( 'post', 'page' ), //post
        "side",
        "high",
        null);
}
add_action("add_meta_boxes", "add_custom_link_box");



function post_meta_link_fields($object){
wp_nonce_field(basename(__FILE__), "meta-box-nonce");
$useurl = get_post_meta($object->ID, "meta-box-custom-useurl", true);
?>
<p><label for="meta-box-custom-url"><?php echo __('Custom Link', 'onepiece'); ?></label>
<input name="meta-box-custom-url" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-custom-url", true); ?>"></p>

<p><label for="meta-box-custom-urltext"><?php echo __('Link text', 'onepiece'); ?></label>
<input name="meta-box-custom-urltext" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-custom-urltext", true); ?>"></p>

<p><label for="meta-box-custom-useurl"><?php echo __('Link function', 'onepiece'); ?></label>
<select name="meta-box-custom-useurl" id="meta-box-custom-useurl">
<option value="replaceself" <?php selected( $useurl, 'replaceself' ); ?>><?php echo __('Replace title link (current window)', 'minimob'); ?></option>
<option value="replaceblank" <?php selected( $useurl, 'replaceblank' ); ?>><?php echo __('Replace title link (new window)', 'minimob'); ?></option>
<option value="internal" <?php selected( $useurl, 'internal' ); ?>><?php echo __('Separate link/button (current window)', 'minimob'); ?></option>
<option value="external" <?php selected( $useurl, 'external' ); ?>><?php echo __('Separate link/button (new window)', 'minimob'); ?></option>
<option value="hide" <?php selected( $useurl, 'hide' ); ?>><?php echo __('Hide the title/link', 'minimob'); ?></option>
</select>
</p>
<?php
}


/* SAVE POST METADATA */
function save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    //$slug = "post";
    //if($slug != $post->post_type)
    //    return $post_id;

    /* LINK META */
    $url = esc_url_raw( $_POST["meta-box-custom-url"] );
    $urltext = $_POST["meta-box-custom-urltext"];
    if ( empty( $urltext ) ) {
       delete_post_meta( $post_id, 'meta-box-custom-urltext' );
    } else {
      update_post_meta( $post_id, 'meta-box-custom-urltext', $urltext );
    }
    if ( empty( $url ) ) {
       delete_post_meta( $post_id, 'meta-box-custom-url' );
    } else {
      update_post_meta( $post_id, 'meta-box-custom-url', $url );
    }
    if( isset( $_POST['meta-box-custom-useurl'] ) )
        update_post_meta( $post_id, 'meta-box-custom-useurl', esc_attr( $_POST['meta-box-custom-useurl'] ) );
}
add_action("save_post", "save_custom_meta_box", 10, 3);
?>
