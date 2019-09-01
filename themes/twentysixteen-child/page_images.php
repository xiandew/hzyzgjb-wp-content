<?php
/* Template Name: page_images */

get_header(); ?>
<style>
.image-container {
  position: relative;
  overflow: hidden;
}

.placeholder {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 140%;
  background-color: rgb(241, 240, 240);
}


.picture {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  transition: opacity 1s linear;
}


.picture.loaded {
  opacity: 1;
  position: relative;
}
</style>
<script>
window.onload = function() {
  let imgContainers = document.getElementsByClassName('image-container');
  
  // Load large image
  for (let i = 0; i < imgContainers.length; i++) {
	  let imgContainer = imgContainers[i];
	  let imgLarge = new Image();
	  imgLarge.src = imgContainer.dataset.large; 
	  imgLarge.onload = function () {
		imgContainer.removeChild(imgContainer.firstChild);
		imgLarge.classList.add('loaded');  
	  };
	  imgLarge.classList.add('picture');
	  imgContainer.appendChild(imgLarge);
  }
}

</script>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>