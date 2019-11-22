<?php 
get_header();
?>

<main>

	<section class="hero-section">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<h1 class="section-heading text-uppercase font-weight-bold"><?php the_field('hero_section_heading'); ?></h1>
					<h3 class="section-subheading pb-4"><?php the_field('hero_section_subheading'); ?></h3>
					<a href="#" class=""></a>
					<?php 
					$link = get_field('work_btn');
					if( $link ): 
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<a class="custom-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section id="about-section" class="about-us py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3 class="section-heading"><?php the_field('about_section_heading'); ?></h3>
					<?php the_field('about_section_text'); ?>
				</div>
				<div class="col-md-6">
					<div class="img-holder">
						<?php 
						$image = get_field('about_side_image');
						$size = 'full'; // (thumbnail, medium, large, full or custom size)
						if( $image ) {
							echo wp_get_attachment_image( $image, $size );
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="services-section" class="services py-5">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center pb-5">
					<h2 class="section-heading"><?php the_field('services_section_heading'); ?></h2>
				</div>
			</div>
			<div class="row">
				
				<?php if(have_rows('service_boxes')) :
					while( have_rows('service_boxes') ) : the_row(); ?>
					<div class="col-md-4">
						<div class="service-box mb-md-5 h-100">
							<div class="service-icon">
								<?php 
									$service_icon = get_sub_field('service_icon');
									echo wp_get_attachment_image( $service_icon, 'full' );
								?>
							</div>
							<div class="service-detail">
								<h5><?php the_sub_field('service_heading') ?></h5>
								<p><?php the_sub_field('service_description'); ?></p>
							</div>
						</div>
					</div>
				<?php
					endwhile;
				endif; ?>

			</div>
		</div>
	</section>

	<section id="testimonial-section" class="testimonial py-5">
		<div class="container">
			<div class="row">
				<div class="col-12 pb-5 text-center">
					<h2 class="section-heading"><?php the_field('testimonial_section_heading'); ?></h2>
				</div>
			</div>

			<?php if( have_rows('testimonial_slider') ) : ?>

				<div class="row">
					<div class="col-12">
						<div class="testimonial-slider owl-carousel owl-theme">
							<?php while( have_rows('testimonial_slider') ) : the_row(); ?>
								<div class="item">
									<div class="client-img">
										<?php 
											$client_img = get_sub_field('client_image');
											echo wp_get_attachment_image( $client_img, 'full', '', array( 'class' => 'img-fluid' ) );
										?>
									</div>
									<div class="client-post text-center py-3">
										<p class="client-words"><?php the_sub_field('client_words'); ?></p>
										<p class="client-name">-- <span><?php the_sub_field('client_name'); ?></span></p>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer();
?>