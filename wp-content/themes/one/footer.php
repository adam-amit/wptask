<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package One
 */

?>


<?php $cta_pos = get_field('cta_position', 'options'); ?>
<section class="floating-cta-bar fixed-<?php echo $cta_pos; ?> text-light py-4">
	<div class="container-fluid">
		<div class="row">
			
			<?php 
			$cta_main_text = get_field('cta_main_text', 'options');
			if( $cta_main_text ) : ?>
				<div class="col-md-3">
					<h5 class="section-heading"><?php echo $cta_main_text; ?></h5>
				</div>
			<?php endif; ?>

			<?php 
			$cta_desc = get_field('cta_description', 'options');
			if( $cta_desc ) : ?>
				<div class="col-12 col-md-5">
					<p class="mb-0 text-center"><?php echo $cta_desc; ?></p>
				</div>
			<?php endif; ?>

			<?php
			if( have_rows('cta_buttons', 'options') ) :
				while( have_rows('cta_buttons', 'options') ) : the_row('cta_buttons', 'options'); ?>
					<div class="col text-center">
						<?php $btn = get_sub_field('cta_button'); ?>
						<a href="<?php echo $btn['url']; ?>" target="<?php echo $btn['target'] ? $btn['target'] : '_self'; ?>" class="btn btn-primary text-light"><?php echo $btn['title']; ?></a>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>

			<div class="col-1">
				<button id="cta-btn" type="button" class="close text-light" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	</div>
</section>

<footer class="footer py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<h5 class="section-heading mb-0 pb-3">One</h5>
				<p><?php the_field('footer_about_text', 'option') ?></p>
			</div>
			<div class="col-md-3">
				<h5 class="section-heading mb-0 pb-3">Quick Links</h5>
				<?php 
				wp_nav_menu(array(
					'menu_class' 		=> 'footer-menu',
					'container'			=> 'ul',
					'container_class'	=> 'collapse navbar-collapse',
					'theme_location'	=> 'menu-1',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)); ?>
			</div>
			<div class="col-md-3">
				<h5 class="section-heading mb-0 pb-3">Follow Us</h5>
				<?php if(have_rows('footer_social_icons', 'option')) : ?>
				<ul class="social-menu pb-5">
					<?php while(have_rows('footer_social_icons', 'option')) : the_row(); ?>
					<li>
						<?php $link = get_sub_field('link'); ?>
						<a href="<?php echo $link['url'] ?>">
							<?php 
										$icon = get_sub_field('icon');
										echo wp_get_attachment_image( $icon, 'full' );
									?>
						</a>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			</div>
			<div class="col-md-3">
				<h5 class="section-heading mb-0 pb-3">Subscribe Newsletter</h5>
				<form>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Enter Email">
					</div>
					<button type="submit" class="w-100 btn submit-btn">Subscribe</button>
				</form>
			</div>
		</div>
	</div>
</footer>


<?php wp_footer(); ?>

</body>

</html>
