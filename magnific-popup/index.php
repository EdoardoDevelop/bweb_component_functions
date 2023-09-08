<?php
/**
* ID: magnific-popup    
* Name: Magnific Popup
* Description: Responsive lightbox per immagini
* Icon: dashicons-images-alt2
* Version: 1.0
* 
*/


class bc_magnificpopupSettings {
	private $magnificpopup_settings_options;

	public function __construct() {
		$this->magnificpopup_settings_options = get_option( 'magnificpopup_settings_option' ); 
		add_action( 'admin_menu', array( $this, 'magnificpopup_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'magnificpopup_settings_page_init' ) );
		add_action('admin_enqueue_scripts', array( $this, '_enqueue_scripts' ));
		add_action('admin_footer-bweb-component_page_magnificpopup', array( $this, 'admin_js_theme' ));
        add_action( 'wp_enqueue_scripts', array( $this, 'load_magnificpopup') );
	}

	public function magnificpopup_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Magnific Popup', // page_title
			'Magnific Popup', // menu_title
			'manage_options', // capability
			'magnificpopup', // menu_slug
			array( $this, 'magnificpopup_settings_create_admin_page' ) // function
		);

	}

	public function magnificpopup_settings_create_admin_page() {
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Magnific Popup</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'magnificpopup_settings_option_group' );
				?>
					<?php
						do_settings_sections( 'magnificpopup-settings' );
						?>
					
					<?php
					submit_button();
				?>
				
			</form>
		</div>
	<?php }

	public function magnificpopup_settings_page_init() {
		register_setting(
			'magnificpopup_settings_option_group', // option_group
			'magnificpopup_settings_option', // option_name
			array( $this, 'magnificpopup_settings_sanitize' ) // sanitize_callback
		);

		
		add_settings_section(
			'magnificpopup_settings_section', // id
			'', // title
			'', // callback
			'magnificpopup-settings' // page
		);

		add_settings_field(
			'script_magnificpopup', // id
			'JS Magnific Popup', // title
			array( $this, 'script_magnificpopup_callback' ), // callback
			'magnificpopup-settings', // page
			'magnificpopup_settings_section' // section
		);

		
	}

	public function magnificpopup_settings_sanitize($input) {
		$sanitary_values = array();
        
		if ( isset( $input['script_magnificpopup'] ) ) {
			$sanitary_values['script_magnificpopup'] = $input['script_magnificpopup'];
		}


		return $sanitary_values;
	}

	
	public function script_magnificpopup_callback() {
		
		printf(
			'<textarea name="magnificpopup_settings_option[script_magnificpopup]" id="script_magnificpopup">%s</textarea>',
			( isset( $this->magnificpopup_settings_options['script_magnificpopup'] )) ? esc_attr( $this->magnificpopup_settings_options['script_magnificpopup']) : ''
			
		);
	}

	public function _enqueue_scripts($hook){
		

		if($hook == 'bweb-component_page_magnificpopup'){
			wp_enqueue_code_editor(array('type' => 'text/html'));
			
		
			wp_enqueue_script('wp-theme-plugin-editor');
			wp_enqueue_style('wp-codemirror');
			
		}
	}

	public function admin_js_theme($hook){
		?>
		<script>
			jQuery(document).ready(function($) {
				var editorSettingsJS = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettingsJS.codemirror = _.extend(
					{},
					editorSettingsJS.codemirror,
					{
						indentUnit: 2,
						tabSize: 2,
						mode: 'javascript'
					}
				);

				
				
                wp.codeEditor.initialize( $('#script_magnificpopup'), editorSettingsJS );
				
				
			})
		</script>
		<?php
	}

	public function load_magnificpopup(){
        wp_enqueue_script( 'magnificpopup-dist-scripts', plugin_dir_url( DIR_COMPONENT .  '/bweb_component_functions/' ) . 'magnific-popup/assets/jquery.magnific-popup.min.js', array( 'jquery' ),'', true );

        if( isset( $this->magnificpopup_settings_options['script_magnificpopup'] )){
            wp_register_script( 'magnificpopup-scripts', '', array("jquery"), '', true );
            wp_enqueue_script( 'magnificpopup-scripts'  );
            wp_add_inline_script( 'magnificpopup-scripts', $this->magnificpopup_settings_options['script_magnificpopup']);
        }
        
    }

}
new bc_magnificpopupSettings();

