<div class="row">
    <div class="col-12">
        <h1><?php the_title(); ?></h1>
        <?php 
        $terms = get_the_terms( get_the_ID(), 'technology' );

        if( $terms && ! is_wp_error( $terms ) ) :
            echo '<div class="service-cat-terms">';
            echo '<h5 class="text-dark d-inline-block pr-3">Category : </h5>';
                foreach($terms as $term ) {
                    echo '<span class="mr-3"><a class="text-light" href="' . get_term_link( $term ) .'">' . $term->name . '</a></span>';
                }
            echo '</div>';
        endif;
        
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <p><?php the_content(); ?></p>
    </div>
    <div class="col-md-4">
        <div class="single-testimonial-img">
            <?php the_post_thumbnail(); ?>
        </div>
    </div>
</div>