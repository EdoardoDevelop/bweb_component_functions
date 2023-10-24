<?php
class BcThemeSettingsCreate {
    private $bctheme_settings_options;
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'bctheme_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bctheme_settings_page_init' ) );
        global $pagenow;
        if($pagenow=='admin.php' && $_GET['page']=='theme-crea'){
            add_action('admin_footer', array( $this, 'custom_admin_js' ) );
        }
	}

	public function bctheme_settings_add_plugin_page() {
		add_submenu_page(
            'theme',
			'Impostazioni Tema - Crea', // page_title
			'Impostazioni Tema', // menu_title
			'manage_options', // capability
			'theme-crea', // menu_slug
			array( $this, 'bctheme_settings_create_admin_page' ) // function
		);

	}
	public function bctheme_settings_create_admin_page() {
        $this->bctheme_settings_options = get_option( 'bctheme_settings_option' );
		?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Impostazioni Tema</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
                require plugin_dir_path( __FILE__ ) ."menu_tab.php";
				settings_fields( 'bctheme_settings_option_group' );
				?>
                <div style="padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">
					<?php
						do_settings_sections( 'bctheme-settings-create' );
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
			'bctheme_settings_option_group', // option_group
			'bctheme_settings_option', // option_name
			array( $this, 'bctheme_settings_sanitize' ) // sanitize_callback
		);
        add_settings_section(
			'bctheme_settings_create_section', // id
			'', // title
			'', // callback
			'bctheme-settings-create' // page
		);

        add_settings_field(
			'theme', // id
			'Tema', // title
			array( $this, 'theme_callback' ), // callback
			'bctheme-settings-create', // page
			'bctheme_settings_create_section' // section
		);
		add_settings_field(
			'nome', // id
			'Nome Tema', // title
			array( $this, 'nome_callback' ), // callback
			'bctheme-settings-create', // page
			'bctheme_settings_create_section' // section
		);

        
    }

    public function bctheme_settings_sanitize($input) {
        $folder_theme = '';
        $sanitary_values = array();
        if ( isset( $input['nome'] ) ) {
            if ( !empty( $input['nome'] ) ){

                $sanitary_values['nome'] = sanitize_text_field( $input['nome'] );
                $slug_name = $this->sanitize_theme_title( $sanitary_values['nome'] );
                $folder_theme = WP_CONTENT_DIR  . '/themes/' . $slug_name;

                if ( isset( $input['theme'] ) ) {
                    if ( $input['theme'] == 'childtheme' ){

                        if (!is_dir($folder_theme)) {
                            if (!mkdir($folder_theme)) { 
                                exit("Failed to create $folder_theme");
                            };
                        }
                        $datastylechild = '/*' . PHP_EOL;
                        $datastylechild .= 'Theme Name:   '.wp_get_theme(get_option('template'))->Name.' Child' . PHP_EOL;
                        $datastylechild .= 'Description:  '.wp_get_theme(get_option('template'))->Name.' Child Theme' . PHP_EOL;
                        $datastylechild .= 'Template:     '.wp_get_theme(get_option('template'))->template . PHP_EOL;
                        $datastylechild .= '*/';
                        file_put_contents($folder_theme.'style.css',$datastylechild);

                        //update_option( 'stylesheet', $slug_name );
                    }else{

                        if (!is_dir($folder_theme)){
                            $return_copy = $this->copyfolder(PLUGIN_THEME_DIR .$input['theme'], $folder_theme);

                            if($return_copy){

                                $strStyle=file_get_contents($folder_theme . '/style.css');
                                $strStyle=str_replace('!######!', $sanitary_values['nome'],$strStyle);
                                file_put_contents($folder_theme . '/style.css', $strStyle);

                                $strFunctions=file_get_contents($folder_theme . '/functions.php');
                                $strFunctions=str_replace('!######!', $slug_name,$strFunctions);
                                file_put_contents($folder_theme . '/functions.php', $strFunctions);

                                $name_th = $slug_name;

                                update_option( 'template', $name_th );
                                update_option( 'stylesheet', $name_th );
                            }
                        }

                        

                        
                        return $sanitary_values;
                    }
                }else{
                    add_settings_error(
                        'bctheme_settings',
                        esc_attr( 'bctheme_settings' ),
                        'Tema richiesto!',
                        'error'
                    );
                }
            }else{
                add_settings_error(
                    'bctheme_settings',
                    esc_attr( 'bctheme_settings' ),
                    'Nome tema richiesto!',
                    'error'
                );
            }
        }
		
	}

    public function nome_callback() {
		printf(
			'<input class="regular-text" type="text" name="bctheme_settings_option[nome]" id="nome" value="%s">',
			isset( $this->bctheme_settings_options['nome'] ) ? esc_attr( $this->bctheme_settings_options['nome']) : ''
		);
	}

    public function theme_callback() {
        ?>
        <label style="display: inline-block; margin:5px; text-align:center">
            <img style="width:200px" src="<?php echo get_template_directory_uri().'/screenshot.png'; ?>" alt="">
            <br>
            <input type="radio" class="radio_theme" name="bctheme_settings_option[theme]" value="childtheme" /> <strong><?php echo wp_get_theme(get_option('template'))->Name; ?> - Child</strong>
        </label>
        <?php
		$foldertheme = scandir(PLUGIN_THEME_DIR  . 'file_theme/');
        foreach($foldertheme as $theme) {
            if (!in_array($theme,array(".",".."))){
                ?>
                <label style="display: inline-block; margin:5px; text-align:center">
                    
                    <img style="width:200px" src="<?php echo plugin_dir_url( PLUGIN_THEME_DIR ) . 'theme/file_theme/'.$theme.'/screenshot.png'; ?>" alt="">
                    <br>
                    <input type="radio" class="radio_theme" name="bctheme_settings_option[theme]" value="<?php echo $theme; ?>" /> <strong><?php echo $theme; ?></strong>
                </label>
                <?php
            }
        }
	}

	

    public function copyfolder ($from, $to, $ext="*") {
        // (A1) SOURCE FOLDER CHECK
        if (!is_dir($from)) { exit("$from does not exist"); }
       
        // (A2) CREATE DESTINATION FOLDER
        if (!is_dir($to)) {
            if (!mkdir($to)) { 
                exit("Failed to create $to");
            };
          //echo "$to created\r\n";
        }
       
        $dir = opendir($from);
        @mkdir($to);
        while(( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($from . '/' . $file) ) {
                    $this->copyfolder($from .'/'. $file, $to .'/'. $file);
                }
                else {
                    copy($from .'/'. $file,$to .'/'. $file);
                }
            }
        }
        closedir($dir);
        return true;
    }

    public function sanitize_theme_title($string){
		return str_replace('-', '_',sanitize_title($string));
	}
	
	public function deleteAll($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
              if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") 
                $this->deleteAll($dir."/".$object); 
                else unlink   ($dir."/".$object);
              }
            }
            reset($objects);
            rmdir($dir);
        }
    }

	public function copyfile($from, $to){
		return copy($from,$to);
	}
	public function deletefile($file){
		return unlink($file);
	}

    public function custom_admin_js(){
        ?>
        <script>
			jQuery(document).ready(function($) {
                var original_value = $('#nome').val();
                $(".radio_theme").change(function (e) { 
                    e.preventDefault();
                    var val= $('input.radio_theme:checked').val();
                    if(val == 'childtheme'){
                        $('#nome').attr('readonly', 'readonly');
                        $('#nome').val('<?php echo wp_get_theme(get_option('template'))->Name; ?> - Child');
                    }else{
                        $('#nome').removeAttr('readonly');
                        $('#nome').val(original_value);
                    }
                });
            });
        </script>
        <?php
    }

}
new BcThemeSettingsCreate();