<?php
get_header();
?>

<main>

	<section class="single-post py-5 testimonial-<?php the_ID(); ?>">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part('template-parts/content', 'service');
                        
                    endwhile;
                    ?>
				</div>
				<div class="col-md-8 text-center">

					<nav>
						<ul class="pagination ml-0 justify-content-between">
							<?php echo get_next_posts_link(); ?>
							<?php echo get_previous_posts_link(); ?>
							<li class="page-item"><?php previous_post_link(); ?></li>
							<li class="page-item"><?php next_post_link(); ?></li>
						</ul>
					</nav>

				</div>

				<div class="col-12">
					<?php 
                    
                    $terms = get_the_terms( get_the_ID(), 'technology' );

					if( $terms && ! is_wp_error( $terms ) ) :
						
						$terms_arr = array();
						
						foreach( $terms as $term ) {
							array_push( $terms_arr, $term->slug );
						}

                        $relatedPosts = new WP_Query( array(
                            'post_type'         => 'service',
                            'tax_query'         => array(
                                array(
                                    'taxonomy' 	=> 'technology',
                                    'field' 	=> 'slug',
                                    'terms' 	=> $terms_arr
                                )
                            ),
                            'posts_per_page'    => 3,
                            'post__not_in'      => array( get_the_ID() )
                        ) );


                        if( $relatedPosts->have_posts() ) :
                    ?>
					<div class="row">
						<div class="col-12 py-3">
							<h3 class="text-dark">Related Services</h3>
						</div>
					</div>
					<div class="row">
						<?php while( $relatedPosts->have_posts() ): $relatedPosts->the_post(); ?>

						<div class="col-md-4 pb-4">
							<div class="card">
								<div class="card-img-top">
									<?php the_post_thumbnail(); ?>
								</div>
								<div class="card-body">
									<h5><a class="text-dark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h5>
									<p><?php echo wp_trim_words( get_the_content(), '50', '...' ) ?></p>
									<a href="<?php the_permalink(); ?>" class="custom-btn">Read More</a>
								</div>
							</div>
						</div>

						<?php endwhile; ?>

					</div>
					<?php endif; ?>

					<?php endif; ?>

				</div>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();
?>
