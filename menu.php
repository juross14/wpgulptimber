<?php 
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */
?>
  <div class="header vertical">  
    <aside id="nav-vertical" class="menu-vertical">
        <div class="container-vertical">
                <a class="navbar-brand" href="<?php echo home_url(); //make logo a home link?>">
                <?php 
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hambleton-hall-logo.svg" class="head-logo">
                </a>
                <div class="call-information">
                    <span><a href="tel:<?php echo get_bloginfo('name');?>"><?php echo get_bloginfo('name');?></a> </span>
                    <span><a href="mailto:<?php echo get_bloginfo('description');?>"><?php echo get_bloginfo('description');?></a></span>
                </div>   
                <div class="call-to-book">
                    <a href="#" class="call-btn">
                       <span class="headline-btn"> Book a Room</span>
                       <span class="subline-btn"> Best Rate Guaranteed </span> 
                    </a>    
                </div>
                
                <div class="navertical-flex-column" id="primary-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="flex-column">%3$s</ul>',
                        'depth' => 2,
                        'walker' => new bootstrap_5_wp_nav_menu_walker()
                    ));
                    ?>
                </div>
                <div class="featured-partners">
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/relais-chateaux.svg" class="Partners 1">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/pride-of-britain.svg" class="Partners 2">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/michelin-star.svg " class="Partners 3">
                    </div>    
                </div>
        </div>
    </aside>
    <nav class="navbar navbar-expand-md navbar-light main-nav">
            <div class="container-fluid hamburger-section-horizontal">
                <a class="navbar-brand" href="<?php echo home_url(); //make logo a home link?>">
                <?php 
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hambleton-hall-logo.svg" class="head-logo">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s flex-column horizontal-menu">%3$s</ul>',
                        'depth' => 2,
                        'walker' => new bootstrap_5_wp_nav_menu_walker()
                    ));
                    ?>
                </div>
            </div>
            <div class="mobile-cont">
                <div class="call-to-book hamburger-horizontal">
                        <a href="#" class="call-btn">
                        <span class="headline-btn"> Book a Room</span>
                        <span class="subline-btn"> Best Rate Guaranteed </span> 
                        </a>    
                </div>
                <div class="call-information hamburger-horizontal">
                    <span><a href="tel:<?php echo get_bloginfo('name');?>"><?php echo get_bloginfo('name');?></a> </span>
                    <span><a href="mailto:<?php echo get_bloginfo('description');?>"><?php echo get_bloginfo('description');?></a></span>
                </div> 
            </div>
        </nav>
    </div> 
<!--  End blog header -->
   