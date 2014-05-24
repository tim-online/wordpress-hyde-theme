<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Hyde 1.0
 */
class Hyde_Header_Fontsize {
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    *
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since Hyde 1.0
    */
   public static function register ( $wp_customize ) {
      //1. Register new settings to the WP database...
      $wp_customize->add_setting( 'header_fontsize', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => null, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );

      //2. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'hyde_header_fontsize', //Set a unique ID for the control
         array(
            'label' => __( 'Header Fontsize', 'hyde' ), //Admin-visible name of the control
            'section' => 'title_tagline', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'header_fontsize', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         )
      ) );
   }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    *
    * Used by hook: 'wp_head'
    *
    * @see add_action('wp_head',$func)
    * @since Hyde 1.0
    */
   public static function header_output() {
      ?>
      <!--Customizer CSS-->
      <style type="text/css">
           <?php self::generate_css('.sidebar h1', 'font-size', 'header_fontsize'); ?>
      </style>
      <!--/Customizer CSS-->
      <?php
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     *
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since Hyde 1.0
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Hyde_Header_Fontsize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Hyde_Header_Fontsize' , 'header_output' ) );
