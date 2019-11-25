<?php 
get_header();
?>

<main>

	<section class="contact-header">
		<div class="container">
			<div class="row">
				<div class="col-12 text-light">
					<h1><?php the_field('contact_header_text'); ?></h1>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-details py-5">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<h3 class="section-heading"><?php the_field('schedule_meeting_heading'); ?></h3>
                    <p><?php the_field('contact_email') ?></p>
                    <?php the_field('visit_us_text'); ?>
					<div class="embed-responsive embed-responsive-16by9">
                        <?php
                        $map = get_field('map');
                        if( $map ) : 
                            echo $map;
                        endif;
                        ?>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
?>
