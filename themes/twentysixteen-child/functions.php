<?php
function my_theme_enqueue_styles() {
	// This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $parent_style = 'twentysixteen-style';
	
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


/**
 * Return true if has_post_thumbnail() or has images in content
 */
function my_has_post_thumbnail() {
	global $post;
	return has_post_thumbnail() || get_children(
		array(
			'numberposts' => 1,
			'order' => 'ASC',
			'post_mime_type' => 'image',
			'post_parent' => $post->ID,
			'post_status' => null,
			'post_type' => 'attachment',
		)
	);
}

function my_get_post_thumbnail() {
	global $post;
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
	} else {
		foreach (
			get_children(
				array(
					'numberposts' => 1,
					'order' => 'ASC',
					'post_mime_type' => 'image',
					'post_parent' => $post->ID,
					'post_status' => null,
					'post_type' => 'attachment',
				)
			) as $first_attachment_image ) {
				echo wp_get_attachment_image( $first_attachment_image->ID , $size = 'post-thumbnail' );
		}
	}
}

/**
 * Display the thumbnail or the first image in the content in the masonry layout
 * of the front page
 */
function my_post_thumbnail() {
	global $post;
	if ( post_password_required() || is_attachment() || is_singular() || !my_has_post_thumbnail() ) {
		return;
	}
	my_get_post_thumbnail();
}

/**
 * Display the thumbnail or the first image in the content in the post list layout
 * of the archive page
 */
function twentysixteen_post_thumbnail() {
	global $post;
	if ( post_password_required() || is_attachment() || is_singular() || !my_has_post_thumbnail() ) {
		return;
	}
	?>
	<a class="my-post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php my_get_post_thumbnail() ?>
	</a>
	<?php
}

function my_excerpt() {
	global $pages, $page;
	$content = $pages[$page-1];
	echo
		preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ?
		replace_whitespaces( strip_tags( explode( $matches[0], $content, 2 )[0] ) ) :
		wp_trim_words( replace_whitespaces(
			strip_tags( strip_html_tags( array('script', 'style'), $content ) )
		), 70, ' [...]' );
}

function twentysixteen_excerpt( $class = 'my-excerpt' ) {
	$class = esc_attr( $class );
	if ( is_search() ) : ?>
		<div class="<?php echo $class; ?>">
			<?php the_excerpt(); ?>
		</div><!-- .<?php echo $class; ?> -->
	<?php endif;
}

function meta_seo() {
    $description =
		"山东省菏泽一中国际部，秉持“中西融合，国际视野，高端素质”的教育理念，" .
		"既重视中国教育的传统优势，又强调国外教育的创新思维和灵活运用能力，" .
		"培养具有国际视野的创新型人才。咨询电话：5296069 5296269 5296369";
    $keywords =
		"菏泽一中国际部," .
		"菏泽第一中学国际部官网";

	if ( is_single() ) {
        global $post;
        $meta_description = get_post_meta($post->ID, "description", true);
        if ( $meta_description ) {
            $description = $meta_description;
        } else {
            $description =
                str_replace(PHP_EOL, "",
                    mb_strimwidth(
                        strip_tags($post->post_content) , 0, 100, "…", 'utf-8'
                    )
                );
        }
        $meta_keywords = get_post_meta($post->ID, "keywords", true);
        if ( $meta_keywords ) {
            $keywords .= "," . $meta_keywords;
        } else {
            $tags = wp_get_post_tags($post->ID);
            foreach ($tags as $tag) {
                $keywords .= "," . $tag->name;
            }
        }
    }
	elseif ( is_category() ) {
        $keywords .= "," . single_cat_title('', false);
    }
	elseif ( is_tag() ) {
        $keywords .= "," . single_tag_title('', false);
    }
    $description = rtrim(strip_tags($description), ", ");
    $keywords = rtrim(strip_tags($keywords), ", ");
    
    echo
        '<meta name="keywords" content="' . $keywords . '" />' .
        '<meta name="description" content="' . $description . '" />';
}
add_action('wp_head', 'meta_seo');

// for referencing wechat resources
function meta_referrer() {
	echo '<meta name="referrer" content="never">';
}
add_action('wp_head', 'meta_referrer');

// strip specified tags and their wrapped contents
function strip_html_tags($tags,$str){
    $html=array();
    foreach ($tags as $tag) {
        $html[]='/<'.$tag.'.*?>[\s|\S]*?<\/'.$tag.'>/';
        $html[]='/<'.$tag.'.*?>/';
    }
    $str = preg_replace($html,'',$str);
    return $str;
}

function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

/**
 * customise the register page
 */
function custom_login_headerurl() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_headerurl' );

function custom_login_headertitle () {
    return __( '山东省菏泽一中国际部官网' );
}
add_filter('login_headertitle','custom_login_headertitle');

function custom_login_style() {
    echo
		'<style>
			#login {
				padding: 2.5rem 0;
			}
			.login h1 a {
				background: url(' . get_header_image() . ') round;
				height: 50px;
				width: 320px;
				margin: 0 auto 3.5rem;
			}
			.login form {
				margin: 0 auto 3rem;
			}
			.login input[type="text"],
			.login input[type="email"],
			.login input[type="password"] {
				font-size: 1rem;
				line-height: 2.5rem;
				padding: 0 0.5rem;
				margin: 0.5rem 0 1rem 0;
				border: none;
				box-shadow: none;
				border-bottom: solid 2px rgb(101, 119, 134);
				border-radius: 2px;
			}
			.login input[type="text"]:focus,
			.login input[type="email"]:focus,
			.login input[type="password"]:focus {
				border-color: rgb(29, 161, 242);
			}
			.login #backtoblog, .login #nav {
				padding: 0;
			}
			.login .button-primary {
				width: 100%;
				border-radius: 15px;
			}
			.login form .forgetmenot {
				margin: 0 0.25rem 1rem !important;
			}
			.login .button.wp-hide-pw {
				top: 0.6rem;
			}
		</style>';
}
add_action('login_head', 'custom_login_style');

// replace multiple whitespaces including new line and unicode characters with
// only one whitespace
function replace_whitespaces( $str ) {
	$str = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", " ", strip_tags($str));
	$str = preg_replace('/\s(?=\S)/', ' ', $str);
	return $str;
}

// delete url field from comment form
function remove_website_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_website_field');
?>