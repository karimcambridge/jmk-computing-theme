<?php
/**
 *    The template for displaying the header.
 *
 * @package    WordPress
 * @subpackage illdy
 */
?>
<?php
$logo_id                   = get_theme_mod( 'custom_logo' );
$logo_image                = wp_get_attachment_image_src( $logo_id, 'full' );
$text_logo                 = get_theme_mod( 'illdy_text_logo', __( 'Illdy', 'illdy' ) );
$jumbotron_general_image   = get_theme_mod( 'illdy_jumbotron_general_image', esc_url( get_template_directory_uri() . '/layout/images/front-page/front-page-header.png' ) );
$jumbotron_type            = get_theme_mod( 'illdy_jumbotron_background_type', 'image' );
$jumbotron_single_image    = get_theme_mod( 'illdy_jumbotron_enable_featured_image', false );
$jumbotron_parallax_enable = get_theme_mod( 'illdy_jumbotron_enable_parallax_effect', true );
$preloader_enable          = get_theme_mod( 'illdy_preloader_enable', 1 );
$is_mobile_safari          = preg_match( '/(iPod|iPhone|iPad)/', $_SERVER['HTTP_USER_AGENT'] );

$style = '';

if ( 'page' == get_option( 'show_on_front' ) && is_front_page() ) {
	if ( $jumbotron_general_image && 'image' == $jumbotron_type ) {
		$style = 'background-image: url(' . esc_url( $jumbotron_general_image ) . ');';
	}
} elseif ( ( is_single() || is_page() ) && true == $jumbotron_single_image ) {

	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$style = 'background-image: url(' . esc_url( get_the_post_thumbnail_url( $post->ID, 'full' ) ) . ');';
	} else {
		$style = 'background-image: url(' . get_header_image() . ');';
	}
} else {
	$style = 'background-image: url(' . get_header_image() . ');';
}

$url = get_theme_mod( 'header_image', get_theme_support( 'custom-header', 'default-image' ) );

// append the parallax effect
if ( $is_mobile_safari ) {
	$style .= 'background-attachment: scroll;';
} elseif ( $jumbotron_parallax_enable ) {
	$style .= 'background-attachment: fixed;';
}

if ( ( is_single() || is_page() || is_archive() ) && get_theme_mod( 'illdy_archive_page_background_stretch' ) == 2 ) {
	$style .= 'background-size:contain;background-repeat:no-repeat;';
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="keywords"  content="cloud based services, web design, website design, create a website, website builder, web design company, website developer, website consultant, web design consultant, consulting companies, consulting company, business consulting, it consultant website, web development consultant, it support, it services, computing services, technical consultant, it consulting services, graphic designing, graphic design, graphic art, visual design, web graphic design, computer graphic design, business card design, custom business cards, custom software development, software development services, custom software solutions, custom made software, software development company, software design company " />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( 1 == $preloader_enable && ! is_customize_preview() ) : ?>
	<div class="pace-overlay"></div>
<?php endif; ?>
<header id="header" class="<?php if ( 'page' == get_option( 'show_on_front' ) && is_front_page() ) : echo 'header-front-page';
else : echo 'header-blog';
endif; ?>" style="<?php echo $style ?>">
	<div class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-xs-8">

					<?php if ( ! empty( $logo_image ) ) { ?>
						<?php echo '<a href="' . esc_url( home_url() ) . '"><img src="' . esc_url( $logo_image[0] ) . '" /></a>'; ?>
					<?php } else { ?>
						<?php if ( get_option( 'show_on_front' ) == 'page' ) { ?>
							<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( $text_logo ); ?>" class="header-logo"><?php echo esc_html( $text_logo ); ?></a>
						<?php } else { // front-page option ?>
							<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="header-logo"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
						<?php } ?>
					<?php } ?>

				</div><!--/.col-sm-2-->
				<div class="col-sm-8 col-xs-4">
					<nav class="header-navigation">
					<?php
						wp_nav_menu( array(
							'theme_location'  => 'primary-menu',
							'menu'            => '',
							'container'       => false,
							'menu_class'      => 'clearfix',
							'menu_id'         => '',
						) );
					?>
					</nav>
					<button class="open-responsive-menu"><i class="fa fa-bars"></i></button>
				</div><!--/.col-sm-10-->
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.top-header-->
	<nav class="responsive-menu">
		<ul>
			<?php
			wp_nav_menu( array(
				'theme_location'  => 'primary-menu',
				'menu'            => '',
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => '',
				'menu_id'         => '',
				'items_wrap'      => '%3$s',
			) );
			?>
		</ul>
	</nav><!--/.responsive-menu-->
	<?php
	if ( get_option( 'show_on_front' ) == 'page' && is_front_page() ) {
		if ( 'video' == $jumbotron_type ) {
			get_template_part( 'sections/front-page', 'header-video' );
		} elseif ( 'slider' == $jumbotron_type ) {
			get_template_part( 'sections/front-page', 'header-slider' );
		}
		get_template_part( 'sections/front-page', 'bottom-header' );
	} else {
		get_template_part( 'sections/blog', 'bottom-header' );
	}
	?>
</header><!--/#header-->
