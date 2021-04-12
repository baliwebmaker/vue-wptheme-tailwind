<?php
get_header();
$special_package = RADL::get( 'state.special_package', get_the_ID() ); ?>

<main>

  <h1><?php echo $page['title']['rendered'];?></h1>

  <div><?php echo $page['content']['rendered'];?></div>

</main>

<?php get_footer(); ?>