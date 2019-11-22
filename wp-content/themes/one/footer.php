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
