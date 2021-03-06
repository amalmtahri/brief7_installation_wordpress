<?php
/**
 * Banner section
 *
 * This is the template for the content of service section
 *
 * @package Theme Palace
 * @subpackage House State
 * @since House State 1.0.0
 */
if ( ! function_exists( 'house_state_add_service_section' ) ) :
    /**
    * Add service section
    *
    *@since House State 1.0.0
    */
    function house_state_add_service_section() {
    	$options = house_state_get_theme_options();
        // Check if service is enabled on frontpage
        $service_enable = apply_filters( 'house_state_section_status', true, 'service_section_enable' );

        if ( true !== $service_enable ) {
            return false;
        }
        // Get service section details
        $section_details = array();
        $section_details = apply_filters( 'house_state_filter_service_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render service section now.
        house_state_render_service_section( $section_details );
}

endif;

if ( ! function_exists( 'house_state_get_service_section_details' ) ) :
    /**
    * service section details.
    *
    * @since House State 1.0.0
    * @param array $input service section details.
    */
    function house_state_get_service_section_details( $input ) {
        $options = house_state_get_theme_options();

        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= 6; $i++ ) {
            if ( ! empty( $options['service_content_page_' . $i] ) )
                $page_ids[] = $options['service_content_page_' . $i];
        }

        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 6,
            'orderby'           => 'post__in',
            );                    
         

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            $i = 1;
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
            $i++;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// service section content details.
add_filter( 'house_state_filter_service_section_details', 'house_state_get_service_section_details' );


if ( ! function_exists( 'house_state_render_service_section' ) ) :
  /**
   * Start service section
   *
   * @return string service content
   * @since House State 1.0.0
   *
   */
   function house_state_render_service_section( $content_details = array() ) {
        $options = house_state_get_theme_options();
        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="services-section" class="relative page-section" >
            <div class="overlay"></div>            
            <div class="wrapper">
                <div class="section-header">
                    <?php if ( !empty( $options['service_section_title'] ) ): ?>
                        <h2 class="section-title"><?php echo esc_html( $options['service_section_title'] ) ; ?></h2>
                    <?php endif ?>
                    <span class="separator">
                        <svg>
                          <g>
                            <path stroke="#A38041" stroke-width="3" d="M0 0 l215 0" />
                            <path stroke="#A38041" stroke-width="2" d="M5,100 v-100" />
                            <path stroke="#A38041" stroke-width="2" d="M10,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M15,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M20 0 v600 400" />
                            <path stroke="#A38041" stroke-width="2" d="M25,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M30,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M35 0 v600 400" />
                            <path stroke="#A38041" stroke-width="2" d="M40,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M45,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M50 0 v600 400" />
                            <path stroke="#A38041" stroke-width="2" d="M55,8 v-50" />
                            <path stroke="#A38041" stroke-width="2" d="M60 0 v600 400" />
                          </g>
                        </svg>
                    </span><!-- .separator -->
                </div><!-- .section-header -->

                <!-- supports column 1, 2 and 4 alaso -->
                <div class="section-content col-3 clear">
                    <?php $i=1; foreach ( $content_details as $content ) : ?>
                        <article>
                            <div class="service-item-wrapper">
                                <?php if ( ! empty( $options['service_content_icon_' .$i] ) ): ?>
                                    <div class="icon-container">
                                        <a href="<?php echo esc_url( $content['url'] ) ; ?>" title="<?php echo esc_attr( $content['title'] ); ?>">
                                            <i class="fa <?php echo  esc_attr( $options['service_content_icon_'.$i] ) ; ?>"></i>
                                        </a>
                                    </div><!-- .icon-container -->
                                <?php endif ?>
                               

                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ) ; ?>" title="<?php echo esc_attr( $content['title'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>
                            </div><!-- service-item-wrapper -->
                        </article>
                    <?php $i++; endforeach; ?>
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #services-section -->       
    <?php
    }    
endif;

function house_state_service_style( ) {
    $options = house_state_get_theme_options();
?>

    <style type="text/css"> 

        <?php if ( !empty( $options['style_service_background'] ) ): ?>
           #services-section{
                background-image: url('<?php echo esc_url( $options['style_service_background'] ); ?>');
           }
       <?php endif ?>

       <?php if ( !empty( $options['style_service_overlay_color'] ) ): ?>
           #services-section .overlay{
                background-color: <?php echo esc_attr( $options['style_service_overlay_color'] ); ?>;
           }
       <?php endif ?>

       <?php if ( !empty( $options['style_service_background_color'] ) ): ?>
           #services-section{
                background-color: <?php echo esc_attr( $options['style_service_background_color'] ); ?>;
           }
       <?php endif ?>

       <?php if ( !empty( $options['style_service_overlay_value'] ) ): ?>
           #services-section .overlay{
                opacity: 0.<?php echo esc_attr( $options['style_service_overlay_value'] ); ?>;
           }
       <?php endif ?>



    </style>
        
<?php 
}

add_action( 'wp_head', 'house_state_service_style' );