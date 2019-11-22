<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package One
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav class="navbar navbar-expand-lg navbar-light sticky-top">
						<a class="navbar-brand" href="<?php echo get_site_url(); ?>">One</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse"
							data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
							aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<?php wp_nav_menu(array(
								'menu_class' 		=> 'navbar-nav ml-auto',
								'container'			=> 'ul',
								'container_class'	=> 'collapse navbar-collapse',
								'theme_location'	=> 'menu-1',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							)); ?>
						</div> 

					</nav>
				</div>
			</div>
		</div>
	</header>
