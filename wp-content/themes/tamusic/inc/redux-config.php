<?php
    /**
     * ReduxFramework Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_ta_config' ) ) {

        class Redux_Framework_ta_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'ta-music' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ta-music' ),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            public function setSections() {

				//Theme Style Sheets 
                $styles = array(
                    'red.css'       => 'Red',
                    'yellow.css'    => 'Yellow',
                    'purple.css'    => 'Purple',
                );

				// Array of social options
                $social_options = array(
                    'Twitter'       => 'Twitter',
                    'Facebook'      => 'Facebook',
                    'Google Plus'   => 'Google Plus',
                    'Instagram'     => 'Instagram',
                    'LinkedIn'      => 'LinkedIn',
                    'Tumblr'        => 'Tumblr',
                    'Pinterest'     => 'Pinterest',
                    'Dribbble'      => 'Dribbble',
                    'Flickr'        => 'Flickr',
					'DeviantArt'    => 'DeviantArt',
                    'Skype'         => 'Skype',
                    'YouTube'       => 'YouTube',
                    'Vimeo'         => 'Vimeo',
                    'GitHub'        => 'GitHub',
                    'RSS'           => 'RSS',
					'SoundCloud'    => 'SoundCloud',
                );

                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'ta-music' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'ta-music' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'ta-music' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'ta-music' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'ta-music' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'ta-music' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'ta-music' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'ta-music' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

				//General Settings
				$this->sections[] = array(
                    'title'         => __( 'General', 'ta-music' ),
                    'heading'       => __( 'General Settings', 'ta-music' ),
                    'desc'          => __( 'Here you can upload site logo and favicon, and choose your favourite color scheme.', 'ta-music' ),
                    'icon'          => 'el el-cog',
                    'fields'        => array(
					   array(
                            'title'     => __( 'Favicon', 'ta-music' ),
                            'subtitle'  => __( 'Use this field to upload your custom favicon.', 'ta-music' ),
                            'id'        => 'custom_favicon',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array(
                            'title'     => __( 'Logo', 'ta-music' ),
                            'subtitle'  => __( 'Use this field to upload your custom logo. Recommended dimensions are 160x55 pixels', 'ta-music' ),
                            'id'        => 'custom_logo',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                       ),

					   array(
							'title'     => __( 'Theme Color Schemes', 'ta-music' ), 
							'subtitle'  => __( 'Select one of the color schemes you like.', 'ta-music' ),
							'id'        => 'css_style',
							'type'      => 'select',
							'default'   => 'red.css',
							'options'   => $styles,
						),
                   ),
				);

				//Top Bar Settings
                $this->sections[] = array(
					'title'         => __( 'Top Bar', 'ta-music' ),
                    'heading'       => __( 'Top Bar Settings', 'ta-music' ),
                    'icon'          => 'el el-chevron-up',
                    'fields'    => array(
						array(
                            'title'     => __( 'Top Bar Section', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Top Bar section.', 'ta-music' ),
                            'id'        => 'disable_top_bar',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                       ),

					   array(
                            'title'     => __( 'Tagline Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Tagline module.', 'ta-music' ),
                            'id'        => 'disable_tagline',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                       ),

					   array(
                            'title'     => __( 'Login & Register Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Login & Register module.', 'ta-music' ),
                            'id'        => 'disable_login_register',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                       ),

					   array(
                            'title'     => __( 'Social Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Social module.', 'ta-music' ),
                            'id'        => 'disable_social',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                       ),

					   array( 
                            'title'     => __( 'Facebook Link', 'ta-music' ),
                            'subtitle'  => __( 'You Facebook page link.', 'ta-music' ),
                            'id'        => 'facebook_link',
                            'default'   => 'http://themeart.co/',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Twitter Link', 'ta-music' ),
                            'subtitle'  => __( 'You Twitter page link.', 'ta-music' ),
                            'id'        => 'twitter_link',
                            'default'   => 'http://themeart.co/',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Google Plus Link', 'ta-music' ),
                            'subtitle'  => __( 'You Google Plus page link.', 'ta-music' ),
                            'id'        => 'google_plus_link',
                            'default'   => 'http://themeart.co/',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'YouTube Link', 'ta-music' ),
                            'subtitle'  => __( 'You YouTube page link.', 'ta-music' ),
                            'id'        => 'youtube_link',
                            'default'   => 'http://themeart.co/',
                            'type'      => 'text',
                        ),

					   array(
                            'title'     => __( 'Search Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Search module.', 'ta-music' ),
                            'id'        => 'disable_search',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                       ),
					)
				);

				// Homepage Settings
                $this->sections[] = array(
					'title'         => __( 'Homepage', 'ta-music' ),
                    'heading'       => __( 'Homepage Setting', 'ta-music' ),
                    'desc'          => __( 'Here you can set Header Slider and Features sections.', 'ta-music' ),
                    'icon'          => 'el el-website',
                    'fields'    => array(
                        array(
                            'title'     => __( 'Header Slider Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Header Slider module.', 'ta-music' ),
                            'id'        => 'disable_slider',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
						),

						array( 
                            'title'     => __( 'Background Image', 'ta-music' ),
                            'subtitle'  => __( 'Use this field to upload your background image for Header Slider module.', 'ta-music' ),
                            'id'        => 'slider_bg',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array(
							'title'       => __( 'Header Slider Box', 'ta-music' ),
							'subtitle'    => __( 'Unlimited Header Slider Box with drag and drop sortings.', 'ta-music' ),
							'desc'        => __( 'You can get Font Awesome Icon <a href="http://fontawesome.io/icons/" target="_blank">here</a>. e.g. folder-open.', 'ta-music' ),
							'id'          => 'header_slider',
							'type'        => 'slides',
							'show'        => array(
								'title'        => true,
								'description'  => true,
								'image_upload' => false,
								'url'          => true,
								'btn_text'     => true,
							),
							'placeholder' => array(
								'title'        => __( 'This is a title.', 'ta-music' ),
								'description'  => __( 'Description here.', 'ta-music' ),
								'url'          => __( 'Link for button.', 'ta-music' ),
								'btn_text'     => __( 'Text for button.', 'ta-music' ),
							),
						),

						array(
                            'title'     => __( 'Features Module', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display Features module.', 'ta-music' ),
                            'id'        => 'disable_features',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
						),

						array( 
                            'title'     => __( 'Features Section Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your title for Features section.', 'ta-music' ),
                            'id'        => 'features_title',
                            'default'   => 'Welcome to <span>TA Music</span> WordPress Theme',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Features Section Description', 'ta-music' ),
                            'subtitle'  => __( 'Add your description for Features section.', 'ta-music' ),
                            'id'        => 'features_description',
                            'default'   => 'TA Music is a powerful and responsive <span>Music, Band & DJ</span> WordPress theme with pretty much advanced features like display Artists, Albums, Photo Galleries, Video Galleries and Events.',
                            'type'      => 'editor',
                        ),

						array(
							'title'       => __( 'Features Box', 'ta-music' ),
							'subtitle'    => __( 'Unlimited Features Box with drag and drop sortings.', 'ta-music' ),
							'desc'        => __( 'You can get Font Awesome Icon <a href="http://fontawesome.io/icons/" target="_blank">here</a>. e.g. fa-folder-open.', 'ta-music' ),
							'id'          => 'features_slider',
							'type'        => 'slides',
							'show'        => array(
								'facode'       => true,
								'title'        => true,
								'description'  => true,
								'image_upload' => false,
								'url'          => true,
							),
							'placeholder' => array(
								'facode'       => __( 'Font Awesome Icon here. e.g. fa-folder-open.', 'ta-music' ),
								'title'        => __( 'This is a title.', 'ta-music' ),
								'description'  => __( 'Description here.', 'ta-music' ),
								'url'          => __( 'Link for title.', 'ta-music' ),
							),
						),
					),
                );

				// Events Settings
                $this->sections[] = array(
                    'title'    => __( 'Event Settings', 'ta-music' ),
                    'heading'  => __( 'Events Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Events Listing page.', 'ta-music' ),
                    'icon'     => 'el el-calendar',
                    'fields'   => array(
						array( 
                            'title'     => __( 'Events Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Events Listing page.', 'ta-music' ),
                            'id'        => 'events_listing_title',
                            'default'   => 'Events',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Events Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Events Listing page.', 'ta-music' ),
                            'id'        => 'events_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Events Listing Style', 'ta-music' ),
                            'subtitle'  => __( 'Select the default Events listing style.', 'ta-music' ),
                            'id'        => 'default_events_style',
                            'default'   => true,
                            'on'        => __( 'List', 'ta-music' ),
                            'off'       => __( 'Grid', 'ta-music' ),
                            'type'      => 'switch',
						),
                    ),
                );

				// Albums Settings
                $this->sections[] = array(
                    'title'    => __( 'Albums Settings', 'ta-music' ),
                    'heading'  => __( 'Albums Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Albums Listing page.', 'ta-music' ),
                    'icon'     => 'el el-headphones',
                    'fields'   => array(
						array( 
                            'title'     => __( 'Albums Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Albums Listing page.', 'ta-music' ),
                            'id'        => 'albums_listing_title',
                            'default'   => 'Albums',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Albums Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Albums Listing page.', 'ta-music' ),
                            'id'        => 'albums_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Albums Listing Page Description', 'ta-music' ),
                            'subtitle'  => __( 'Add your own description for Albums Listing page.', 'ta-music' ),
                            'id'        => 'albums_listing_desc',
                            'default'   => 'Add your own description here.',
                            'type'      => 'editor',
						),

						array( 
                            'title'     => __( 'Display Filter', 'ta-meghna' ),
                            'subtitle'  => __( 'Select to enable/disable the listing filter.', 'ta-music' ),
                            'id'        => 'albums_filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                        ),
                    ),
                );

				// Videos Settings
                $this->sections[] = array(
                    'title'    => __( 'Videos Settings', 'ta-music' ),
                    'heading'  => __( 'Videos Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Videos Listing page.', 'ta-music' ),
                    'icon'     => 'el el-facetime-video',
                    'fields'   => array(
						array( 
                            'title'     => __( 'Videos Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Videos Listing page.', 'ta-music' ),
                            'id'        => 'videos_listing_title',
                            'default'   => 'Videos',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Videos Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Videos Listing page.', 'ta-music' ),
                            'id'        => 'videos_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Videos Listing Page Description', 'ta-music' ),
                            'subtitle'  => __( 'Add your own description for Videos Listing page.', 'ta-music' ),
                            'id'        => 'videos_listing_desc',
                            'default'   => 'Add your own description here.',
                            'type'      => 'editor',
						),

						array( 
                            'title'     => __( 'Display Filter', 'ta-meghna' ),
                            'subtitle'  => __( 'Select to enable/disable the listing filter.', 'ta-music' ),
                            'id'        => 'videos_filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                        ),
                    ),
                );

				// Galleries Settings
                $this->sections[] = array(
                    'title'    => __( 'Galleries Settings', 'ta-music' ),
                    'heading'  => __( 'Galleries Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Galleries Listing page.', 'ta-music' ),
                    'icon'     => 'el el-camera',
                    'fields'   => array(
						array( 
                            'title'     => __( 'Galleries Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Galleries Listing page.', 'ta-music' ),
                            'id'        => 'galleries_listing_title',
                            'default'   => 'Galleries',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Galleries Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Galleries Listing page.', 'ta-music' ),
                            'id'        => 'galleries_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Galleries Listing Page Description', 'ta-music' ),
                            'subtitle'  => __( 'Add your own description for Galleries Listing page.', 'ta-music' ),
                            'id'        => 'galleries_listing_desc',
                            'default'   => 'Add your own description here.',
                            'type'      => 'editor',
						),

						array( 
                            'title'     => __( 'Display Filter', 'ta-meghna' ),
                            'subtitle'  => __( 'Select to enable/disable the listing filter.', 'ta-music' ),
                            'id'        => 'galleries_filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                        ),
                    ),
                );

				// Artists Settings
                $this->sections[] = array(
                    'title'    => __( 'Artists Settings', 'ta-music' ),
                    'heading'  => __( 'Artists Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Artists Listing page.', 'ta-music' ),
                    'icon'     => 'el el-user',
                    'fields'   => array(
						array(
							'title'     => __( 'Artists Listing Page', 'ta-music' ), 
							'subtitle'  => __( 'Select a page for artists listing..', 'ta-music' ),
							'id'        => 'artists_page',
							'type'      => 'select',
							'default'   => '',
							'data'      => 'pages',
						),

						array( 
                            'title'     => __( 'Artists Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Artists Listing page.', 'ta-music' ),
                            'id'        => 'artists_listing_title',
                            'default'   => 'Artists',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Artists Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Artists Listing page.', 'ta-music' ),
                            'id'        => 'artists_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Artists Listing Page Description', 'ta-music' ),
                            'subtitle'  => __( 'Add your own description for Artists Listing page.', 'ta-music' ),
                            'id'        => 'artists_listing_desc',
                            'default'   => 'Add your own description here.',
                            'type'      => 'editor',
						),

						array( 
                            'title'     => __( 'Display Filter', 'ta-meghna' ),
                            'subtitle'  => __( 'Select to enable/disable the listing filter.', 'ta-music' ),
                            'id'        => 'artists_filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
                        ),
                    ),
                );

				// Blog Settings
                $this->sections[] = array(
                    'title'    => __( 'Blog Settings', 'ta-music' ),
                    'heading'  => __( 'Blog Listing Settings', 'ta-music' ),
                    'desc'     => __( 'Here you can set layouts for Blog Listing page.', 'ta-music' ),
                    'icon'     => 'el el-pencil',
                    'fields'   => array(
						array( 
                            'title'     => __( 'Blog Listing Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for Blog Listing page.', 'ta-music' ),
                            'id'        => 'blog_listing_title',
                            'default'   => 'Blog',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Blog Listing Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Blog Listing page.', 'ta-music' ),
                            'id'        => 'blog_listing_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Blog Listing Style', 'ta-music' ),
                            'subtitle'  => __( 'Select the default Blog listing style.', 'ta-music' ),
                            'id'        => 'default_blog_style',
                            'default'   => true,
                            'on'        => __( 'Grid', 'ta-music' ),
                            'off'       => __( 'List', 'ta-music' ),
                            'type'      => 'switch',
						),
                    ),
                );

				//Footer Settings
                $this->sections[] = array(
					'title'     => __( 'Footer Settings', 'ta-music' ),
					'heading'   => __( 'Footer Settings', 'ta-music' ),
                    'desc'      => __( 'Here you can set site copyright information.', 'ta-music' ),
                    'icon'      => 'el el-download-alt',
                    'fields'    => array(
                        array(
                            'title'     => __( 'Custom Copyright', 'ta-music' ),
                            'subtitle'  => __( 'Add your own custom text/html for copyright region. You are <strong style="color:red;">not allowed</strong> to Remove Back Link/Credit unless you <a href="http://themeart.co/support-themeart/" target="_blank">donated us</a>.', 'ta-music' ),
                            'id'        => 'custom_copyright',
                            'default'   => 'Copyright &copy; 2015 - <a href="http://themeart.co/free-theme/ta-music/" title="TA Music Free WordPress Theme" target="_blank">TA Music</a>. Design by <a href="https://twitter.com/BrentChesny" target="_blank">Brent Chesny</a> and Developed by <a href="http://themeart.co/" title="Downlod Free Premium WordPress Themes" target="_blank">ThemeArt</a>.',
                            'type'      => 'editor',
                       ),
                   )
               );

				// Contact Us Settings
                $this->sections[] = array(
                    'title'    => __( 'Contact Us', 'ta-music' ),
                    'heading'  => __( 'Contact Us Setting', 'ta-music' ),
                    'desc'     => __( 'Here you can set contact information.', 'ta-music' ),
                    'icon'     => 'el el-envelope',
                    'fields'   => array(
						array(
                            'title'     => __( 'Contact Us Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for Contact Us page.', 'ta-music' ),
                            'id'        => 'contact_tagline',
                            'default'   => "Let's Keep in Touch",
                            'type'      => 'text',
						),

						array( 
                            'title'     => __( 'Set Your Address', 'ta-music' ),
                            'subtitle'  => __( 'Set your address here.', 'ta-music' ),
                            'id'        => 'contact_address',
                            'default'   => '1600 Amphitheatre Parkway Mountain View, CA 94043',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Set Your Phone Number', 'ta-music' ),
                            'subtitle'  => __( 'Set your phone number here.', 'ta-music' ),
                            'id'        => 'contact_phone',
                            'default'   => '+01 234 567 890',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Contact Email', 'ta-pluton' ),
                            'subtitle'  => __( 'Set your email address. This is where the contact form will send a message to.', 'ta-music' ),
                            'id'        => 'contact_email',
                            'default'   => 'yourname@yourdomain.com',
							'validate'  => 'email',
							'msg'       => __( 'Not a valid email address.', 'ta-music' ),
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'Dislplay Contact Email', 'ta-music' ),
                            'subtitle'  => __( 'Select to enable/disable display contact email.', 'ta-music' ),
                            'id'        => 'disable_contact_email',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-music' ),
                            'off'       => __( 'Disable', 'ta-music' ),
                            'type'      => 'switch',
						),

						array(
                            'title'     => __( 'Google Map Embed Code', 'ta-music' ),
                            'subtitle'  => __( 'Please refer to <a href="http://themeart.co/document/ta-music-theme-documentation/#google-map-settings" target="_blank">theme documentation</a> for how to Embed a Google Map with iFrame.', 'ta-music' ),
                            'id'        => 'map_code',
                            'default'   => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1584.2679903399307!2d-122.09496935581758!3d37.42444119584552!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba1a7f2db7e7%3A0x59c3e570fe8e0c73!2sGoogle+West+Campus+6%2C+2350+Bayshore+Pkwy%2C+Mountain+View%2C+CA+94043%2C+USA!5e0!3m2!1sen!2s!4v1422891258666" width="600" height="450" frameborder="0" style="border:0"></iframe>',
                            'type'      => 'ace_editor',
                            'mode'      => 'html',
                            'theme'     => 'monokai',
                       ),
                    ),
                );

				//404 Page Settings
                $this->sections[] = array(
					'title'     => __( '404 Page', 'ta-music' ),
					'heading'   => __( '404 Page Settings', 'ta-music' ),
                    'desc'      => __( 'Here you can set information for 404 page.', 'ta-music' ),
                    'icon'      => 'el el-icon-error',
                    'fields'    => array(
						array( 
                            'title'     => __( '404 Page Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for 404 page.', 'ta-music' ),
                            'id'        => '404_title',
                            'default'   => '404 Error',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( '404 Page Tagline', 'ta-music' ),
                            'subtitle'  => __( 'Add your own tagline for 404 page.', 'ta-music' ),
                            'id'        => '404_tagline',
                            'default'   => 'Add your own tagline here.',
                            'type'      => 'text',
						),

						array(
                            'title'     => __( 'Notice Title', 'ta-music' ),
                            'subtitle'  => __( 'Add your own title for error notice.', 'ta-music' ),
                            'id'        => '404_notice_title',
                            'default'   => "Whoops! Something's Gone Wrong.",
                            'type'      => 'text',
                       ),
                        array(
                            'title'     => __( 'Notice Information', 'ta-music' ),
                            'subtitle'  => __( 'Add some information for error notice.', 'ta-music' ),
                            'id'        => '404_notice_info',
                            'default'   => 'Sorry, the page you have requested has either been moved, or does not exist. Return to <a href="javascript:history.go(-1)">Previous Page</a>.',
                            'type'      => 'editor',
                       ),
                   )
               );

				//Social Settings
                $this->sections[] = array(
					'title'         => __( 'Social Profiles', 'ta-music' ),
                    'heading'       => __( 'Social Profiles Settings', 'ta-music' ),
                    'desc'          => __( 'Here you can set your social profiles.', 'ta-music' ),
                    'icon'          => 'el el-icon-group',
                    'fields'        => array(
                         array(
                            'title'     => __( 'Social Icons', 'ta-music' ),
                            'subtitle'  => __( 'Arrange your social icons. Add complete URLs to your social profiles.', 'ta-music' ),
                            'id'        => 'social_icons',
                            'type'      => 'sortable',
                            'options'   => $social_options,
                       ),
                   )
               );

			   // Twitter API Settings
                $this->sections[] = array(
					'title'         => __( 'Twitter API', 'ta-music' ),
                    'heading'       => __( 'Twitter API Settings', 'ta-music' ),
                    'desc'          => __( 'You can refer to the <a href="http://themeart.co/document/ta-music-theme-documentation/#twitter-api-settings" target="_blank">theme documentation</a> to get Twitter API Consumer and Secret Keys.', 'ta-music' ),
                    'icon'          => 'el el-twitter',
                    'fields'    => array(
						array(
                            'title'     => __( 'Twitter Consumer Key', 'ta-music' ),
                            'id'        => 'twitter_consumer_key',
                            'default'   => '',
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'Twitter Consumer Secret', 'ta-music' ),
                            'id'        => 'twitter_consumer_secret',
                            'default'   => '',
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'Twitter Access Token', 'ta-music' ),
                            'id'        => 'twitter_access_token',
                            'default'   => '',
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'Twitter Access Token Secret', 'ta-music' ),
                            'id'        => 'twitter_access_token_secret',
                            'default'   => '',
                            'type'      => 'text',
                        ),
					),
                );

			   //Custom CSS
                $this->sections[] = array(
                    'icon'      => 'el el-css',
                    'title'     => __( 'Custom CSS', 'ta-music' ),
                    'fields'    => array(
                         array(
                            'title'     => __( 'Custom CSS', 'ta-music' ),
                            'subtitle'  => __( 'Insert any custom CSS.', 'ta-music' ),
                            'id'        => 'custom_css',
                            'type'      => 'ace_editor',
                            'mode'      => 'css',
                            'theme'     => 'monokai',
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Import / Export', 'ta-music' ),
                    'desc'   => __( 'Import and Export your theme settings from file, text or URL.', 'ta-music' ),
                    'icon'   => 'el el-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'full_width' => false,
						),
					),
				);

                $this->sections[] = array(
                    'type' => 'divide',
				);

                $this->sections[] = array(
                    'icon'   => 'el el-info-circle',
                    'title'  => __( 'Theme Information', 'ta-music' ),
                    'desc'   => __( '<p class="description">About TA Music</p>', 'ta-music' ),
                    'fields' => array(
                        array(
                            'id'      => 'opt-raw-info',
                            'type'    => 'raw',
                            'content' => $item_info,
                       )
                   ),
               );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'ta_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Panel', 'ta-music' ),
                    'page_title'           => __( 'Theme Panel', 'ta-music' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-admin-settings',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://themeart.co/document/ta-music-theme-documentation/',
                    'title' => __( 'Documentation', 'ta-music' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'http://themeart.co/support/',
                    'title' => __( 'Support', 'ta-music' ),
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>You can start customizing your theme with the powerful option panel.</p>', 'ta-music' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ta-music' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>Thanks for using <a href="http://themeart.co/free-theme/ta-music/" target="_blank">TA Music</a>. This free WordPress theme is designed by <a href=
				"http://themeart.co/" target="_blank">ThemeArt</a>. Please feel free to leave us some feedback about your experience, so we can improve our themes for you.</p>', 'ta-music' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_ta_config();
    } else {
        echo "The class named Redux_Framework_ta_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
