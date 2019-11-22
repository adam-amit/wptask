<?php
get_header();
?>

<main>

	<section class="single-post taxonomy-<?php the_ID(); ?>">
		<div class="container">

			<div class="row py-3">
				<div class="col-12">
					<h3 class="font-weight-bold"><?php single_term_title( '<span class="font-weight-normal">Platform used by client(s):</span> ' ); ?></h3>
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
	</section>

</main>

<?php
get_footer();
?>
