<?php
get_header();
?>

<main>

    <section class="single-post testimonial-<?php the_ID(); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part('template-parts/content', 'testimonial');
                        
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>