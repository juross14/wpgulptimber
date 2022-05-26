<?php
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */

$context = Timber::context();
$context['footer_widgets'] = Timber::get_widgets('footer_widgets');
Timber::render('footer.twig', $context);

?>
