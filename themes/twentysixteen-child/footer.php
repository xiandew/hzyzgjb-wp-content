<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		</div><!-- .site-content -->
	</div><!-- .site-inner -->
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if( function_exists('slbd_display_widgets') ) { echo slbd_display_widgets(); } ?>
		<div class="site-info-wrapper">
			<div class="site-info">
				<?php
					/**
					 * Fires before the twentysixteen footer text for footer customization.
					 *
					 * @since Twenty Sixteen 1.0
					 */
					do_action( 'twentysixteen_credits' );
				?>
				<span>
					Copyright © <?php echo date("Y")." "?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</span>
				<span>
					鲁ICP备11014052号-3
				</span>
				<span id="Author-XiandeWen">
					Site & maintained by
					<a href="https://xiandew.github.io/" target="_blank" style="font-weight:bold">
						Xiande Wen
					</a>
				</span>
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
				?>
				<span>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentysixteen' ) ); ?>" class="imprint">
						<?php printf( __( 'Proudly powered by %s', 'twentysixteen' ), 'WordPress' ); ?>
					</a>
				</span>
			</div><!-- .site-info -->
		</div><!-- .site-info-wrapper -->
	</footer><!-- .site-footer -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
