<?php 
get_header();
?>

<main>

    <section class="py-5 testimonial-archive-container">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    
                    <?php
                    if( have_posts() ) : 
                        while( have_posts() ) : the_post(); ?>

                    <div class="row py-3">
                        <div class="col-md-4">
                            <div class="testimonial-single-img">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words( get_the_content(), '50', '...' ) ?></p>
                            <a href="<?php the_permalink(); ?>" class="custom-btn">Read More</a>
                        </div>
                    </div>

                    <?php endwhile; ?>
                    <div class="pagination py-3">
                        <?php echo paginate_links(); ?>
					</div>
                    <?php endif; ?>

                </div>
                
                <div class="col-md-3">
					<h3>Testimonial Tags</h3>
					<?php 
					
					$terms = get_terms( array(
						'taxonomy' => 'platform',
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
    </section>

</main>

<?php
get_footer();
?>