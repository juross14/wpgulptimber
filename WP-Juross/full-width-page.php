<?php
/**
 * Template Name: Fullwidth Template
 * Description: A full-width template with no sidebar
 *
 * Declare ACF fields Variables 
 * @package WordPress
 * @subpackage WP-Skeleton
 */

$context          = Timber::context();
$context['posts'] = new Timber\PostQuery();
$templates        = array( 'full-width-page.twig' );
Timber::render( $templates, $context );

?>

