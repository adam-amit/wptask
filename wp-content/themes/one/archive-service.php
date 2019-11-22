<?php 
get_header();
?>

<main>

	<section class="service-archive-container">

		<div class="container">
			<div class="row">

				<div class="col-md-9">

					<?php if( have_posts() ) :  ?>
					<div class="row">
						<?php while( have_posts() ) : the_post(); ?>

						<div class="col-md-6 py-3">
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
					<div class="pagination py-3">
						<?php echo paginate_links(); ?>
					</div>
					<?php endif; ?>

				</div>

				<div class="col-md-3">
					<h3>Services Category</h3>
					<?php 
					
					$terms = get_terms( array(
						'taxonomy' => 'technology',
						'hide_empty' => false
					) );
					
					if( !empty( $terms ) ) :
						echo '<ul class="service-cat-list">';
							foreach( $terms as $term ) {
								if( $term->parent == 0 ) {
									echo '<li><a class="text-dark" href="'. get_term_link( $term ) .'">' . $term->name . '</a>';
									foreach( $terms as $subcat ) {
										if( $subcat->parent == $term->term_id ) {
											echo '<ul class="service-sub-cat-list">
												<li><a class="text-light" href="' . get_term_link( $subcat ) . '">' . $subcat->name . '</a></li>
											</ul>';
										}
									}
									echo '</li>';
								}
							}
						echo '</ul>';
					endif;

					?>
				</div>

			</div>
		</div>

		<div class="container-fluid testimonial">
			<!-- Testimonial slider here -->
			<?php 
			$testimonials = new WP_Query(array(
				'post_type'			=> 'testimonial',
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
									<p class="client-words"><?php echo wp_trim_words( get_the_content(), '50', '...' ); ?></p>
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
