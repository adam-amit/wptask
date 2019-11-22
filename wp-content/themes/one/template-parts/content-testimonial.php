<div class="row py-5">
    <div class="col-md-8">
        <h1><?php the_title(); ?></h1>
        <p><?php the_content(); ?></p>
    </div>
    <div class="col-md-4">
        <div class="single-testimonial-img">
            <?php the_post_thumbnail(); ?>
        </div>
    </div>
</div>