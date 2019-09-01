<div class="wmle_item_holder <?php echo $shortcodeData['wmlo_columns'] ?>" style="display:none;">
    <div class="wmle_item">
        <?php if ( my_has_post_thumbnail() ):?>
            <div class="wpme_image">
                <a href="<?php the_permalink(); ?>"><?php /*the_post_thumbnail($shortcodeData['wmlo_image_size']);*/ my_post_thumbnail(); ?></a>
            </div>
        <?php endif; ?>
        <div class="wmle_post_meta">
			<?php twentysixteen_entry_date(); ?>
        	<a href="<?php comments_link(); ?>"><?php comments_number('0 comment', '1 comment', '% comments' ) ?></a>
        </div>
        <div class="wmle_post_title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </div>
        <div class="wmle_post_excerpt">
            <?php my_excerpt(); ?>
        </div>
    </div><!-- EOF wmle_item_holder -->
</div><!-- EOF wmle_item_holder -->