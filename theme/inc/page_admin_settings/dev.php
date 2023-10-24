<?php
class BcThemeSettingsDev  {
    public function __construct(){
		add_action( 'admin_menu', array( $this, 'bctheme_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bctheme_settings_page_init' ) );
	}

	public function bctheme_settings_add_plugin_page() {
		add_submenu_page(
            'theme',
			'Impostazioni Tema - Crea', // page_title
			'Impostazioni Tema', // menu_title
			'manage_options', // capability
			'theme-dev', // menu_slug
			array( $this, 'bctheme_settings_create_admin_page' ) // function
		);

	}
	public function bctheme_settings_create_admin_page() {
		?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Impostazioni Tema</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'bctheme_settings_option_group_dev' );
				?>
				<?php
                require plugin_dir_path( __FILE__ ) ."menu_tab.php";
				?>
                <div style="padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">
					<?php
						do_settings_sections( 'bctheme-settings-dev' );
                    ?>
                </div>
                <?php
					submit_button();
				?>
				
			</form>
		</div>
	<?php }
    public function bctheme_settings_page_init() {
		register_setting(
			'bctheme_settings_option_group_dev', // option_group
			'bctheme_settings_option_group_dev', // option_name
			array( $this, 'bctheme_settings_sanitize' ) // sanitize_callback
		);
        
        add_settings_section(
			'bctheme_settings_dev_section', // id
			'', // title
			'', // callback
			'bctheme-settings-dev' // page
		);
        add_settings_field(
			'gen_html', // id
			'Genera file html', // title
			array( $this, 'gen_html_callback' ), // callback
			'bctheme-settings-dev', // page
			'bctheme_settings_dev_section' // section
		);
    }

    public function bctheme_settings_sanitize($input) {
        $folder_theme = WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet' );
        if ( isset( $_REQUEST['gen_html'] ) && $_REQUEST['gen_html'] == 'true' ) {
			if($folder_theme!=''){
				require "generate_html.php";
			}
		}
    }

    public function gen_html_callback(){
		?>
		<button value="true" name="gen_html" class="button button-primary">Genera html da queste impostazioni</button>
		<br>
		<br>
		<strong>Lista dimensioni immagini:</strong><br>
		<?php
		
		$s = wp_get_registered_image_subsizes();
		echo '<ul>';
		foreach ($s as $key => $image_size) {
			echo "<li>{$key} ({$image_size['width']} x {$image_size['height']})</li>";
		}
		echo '</ul>';
	}

}
new BcThemeSettingsDev();