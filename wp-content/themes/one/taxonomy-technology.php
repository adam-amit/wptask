<?php
get_header();
?>

<main>

	<section class="single-post taxonomy-<?php the_ID(); ?>">
		<div class="container">
			<div class="row py-3">
				<div class="col-12">
					<h3 class="font-weight-bold">
						<?php single_term_title( '<span class="font-weight-normal">Service by Technology: </span> ' ); ?></h3>
				</div>
			</div>
			<div class="row py-3">
				<?php while ( have_posts() ) : the_post(); ?>

				<div class="col-md-4">
					<div class="testimonial-card">
						<div class="testimonial-single-img">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="testimonial-single-detail text-center">
							<h3><a class="text-dark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="text-white"><?php echo wp_trim_words( get_the_content(), '50', '...' ) ?>
							</p>
							<a href="<?php the_permalink(); ?>" class="custom-btn">Read More</a>
						</div>
					</div>
				</div>

				<?php endwhile; ?>
			</div>

		</div>

		<div class="container-fluid testimonial">
			<!-- Testimonial slider here -->
			<?php 
				$term = single_term_title( "", false );

				$testimonials = new WP_Query( array(
					'post_type'     	=> 'testimonial',
					'tax_query'     	=> array(
						array( 
							'taxonomy'  => 'platform',
							'field'     => 'name',
							'terms'     => array( $term )
						),
					),
					'posts_per_page'	=> -1
				));

				if( $testimonials->have_posts() ) :
				?>
			<div class="row py-5">
				<div class="col-12 text-center pb-3">
					<h3 class="section-heading">Testimonials from our client</h3>
				</div>
				<div class="col-12">
					<div class="testimonial-slider owl-carousel owl-theme">
						<?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
						<div class="item">
							<div class="client-img">
								<?php the_post_thumbnail(); ?>
							</div>
							<div class="client-post text-center py-3">
								<p class="client-words"><?php echo wp_trim_words( get_the_content(), '50', '...' ); ?>
								</p>
								<p class="client-name">-- <span><?php the_title(); ?></span></p>
							</div>
						</div>
						<?php endwhile; 
							wp_reset_postdata();
							?>
					</div>
				</div>
			</div>
			<!-- Testimonial slider ENDS -->
			<?php endif; ?>
		</div>

	</section>

</main>

<?php
get_footer();
?>
