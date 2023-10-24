<?php

class BcThemeSettings {
	private $arraycheck;
	
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'bctheme_settings_add_plugin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_limit_depth' ));
		add_action( 'admin_init', array( $this, 'bctheme_settings_page_init' ) );
	}

	public function bctheme_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Impostazioni Tema', // page_title
			'Impostazioni Tema', // menu_title
			'manage_options', // capability
			'theme', // menu_slug
			array( $this, 'bctheme_settings_create_admin_page' ) // function
		);

	}

	
	public function bctheme_settings_create_admin_page() {
		$this->arraycheck = array();
		?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Impostazioni Tema</h2>
			<p></p>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'bctheme_settings_option_group_templ' );
				?>
				<?php
                require plugin_dir_path( __FILE__ ) ."page_admin_settings/menu_tab.php";
				?>
                <div style="padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">
					<?php
						do_settings_sections( 'bctheme-settings-template' );
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
			'bctheme_settings_option_group_templ', // option_group
			'bctheme_settings_option_templ', // option_name
			array( $this, 'bctheme_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bctheme_settings_template_section', // id
			'', // title
			'', // callback
			'bctheme-settings-template' // page
		);
		
		add_settings_field(
			'include_file_template', // id
			'File template', // title
			array( $this, 'include_file_template_callback' ), // callback
			'bctheme-settings-template', // page
			'bctheme_settings_template_section' // section
		);

	}
	public function bctheme_settings_sanitize($input) {
		$folder_theme = WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet' );


		if ( isset( $input['include_file_template']['taxonomy'] ) ) {
			
			if(is_array($input['include_file_template']['taxonomy'])) {
				foreach($input['include_file_template']['taxonomy'] as $file ){
					if(!$this->check_template($file)){
						if($this->check_template('archive.php')){
							$this->copyfile($folder_theme . '/archive.php', $folder_theme . '/'.$file);
						}else{
							$this->copyfile($folder_theme . '/index.php', $folder_theme . '/'.$file);
						}
					}
				}
			}
		}
		if ( isset( $input['include_file_template']['cpt'] ) ) {
			
			if(is_array($input['include_file_template']['cpt'])) {
				foreach($input['include_file_template']['cpt'] as $file ){
					if(!$this->check_template($file)){
						$sourcT = explode("-",$file)[0];
						if($this->check_template($sourcT.'.php')){
							$this->copyfile($folder_theme . '/' . $sourcT.'.php', $folder_theme . '/'.$file);
						}else{
							$this->copyfile($folder_theme . '/index.php', $folder_theme . '/'.$file);
						}
					}
				}
			}
		}
				


		foreach($this->arraycheck as $t ){
			if($this->check_template($t)){
				if (!in_array($t, $input['include_file_template']['cpt'])){
					$this->deletefile($folder_theme . '/' . $t);
				}
			}
		}

		return array();
	}



	public function include_file_template_callback() {
				
		$args_custom_post_types = array(
			'public' => true,
			'_builtin' => false
		);
		$custom_post_types = get_post_types( $args_custom_post_types, 'objects' );
		foreach ( $custom_post_types as $post_type_obj ):
			
			$labels = get_post_type_labels( $post_type_obj );
			array_push($this->arraycheck,'archive-'.esc_attr( $post_type_obj->name ).'.php', 'single-'.esc_attr( $post_type_obj->name ).'.php');
		?>

		<div>
			<strong><?php echo esc_html( $labels->name ); ?></strong>
			<ul>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option_templ[include_file_template][cpt][]" value="%s" %s>%s</label>',
							'archive-'.esc_attr( $post_type_obj->name ).'.php',
							$this->check_template('archive-'.esc_attr( $post_type_obj->name ).'.php')  ? 'checked' : '',
							'archive-'.esc_attr( $post_type_obj->name ).'.php'
						);
					?>
				</li>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option_templ[include_file_template][cpt][]" value="%s" %s>%s</label>',
							'single-'.esc_attr( $post_type_obj->name ).'.php',
							$this->check_template('single-'.esc_attr( $post_type_obj->name ).'.php')  ? 'checked' : '',
							'single-'.esc_attr( $post_type_obj->name ).'.php'
						);
					?>
				</li>
			</ul>
		</div>

		<?php

		endforeach;

		array_push($this->arraycheck,'taxonomy.php');
		?>

		<div>
			<strong>Generic Taxonomy</strong>
			<ul>
			
				<li>
				<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option_templ[include_file_template][taxonomy][]" value="taxonomy.php" %s>%s</label>',
							is_dir(WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet' ) . '/woocommerce')  ? 'checked' : '',
							'taxonomy.php'
						);
					?>
				</li>
			</ul>
		</div>

		<?php

			$args = array(
				'public'   => true,
				'_builtin' => false
				
			); 
		foreach ( get_taxonomies($args,'objects') as $taxonomy ):
			
			array_push($this->arraycheck,'taxonomy-'.esc_attr( $taxonomy->name ).'.php');
			?>
		<div>
			<strong><?php echo esc_html( $taxonomy->label ); ?></strong>
			<ul>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option_templ[include_file_template][cpt][]" value="%s" %s>%s</label>',
							'taxonomy-'.esc_attr( $taxonomy->name ).'.php',
							$this->check_template('taxonomy-'.esc_attr( $taxonomy->name ).'.php')  ? 'checked' : '',
							'taxonomy-'.esc_attr( $taxonomy->name ).'.php'
						);
					?>
				</li>
				<?php
				$taxonomies = get_terms( array(
					'taxonomy' => $taxonomy->name,
					'hide_empty' => false
				) );
				foreach( $taxonomies as $category ) {
					array_push($this->arraycheck,'taxonomy-'.$taxonomy->name.'-'.esc_attr( $category->slug ).'.php');
					?>
					<li>&nbsp&nbsp&nbsp&nbsp&nbsp
						<?php
							printf(
								'<label><input type="checkbox" name="bctheme_settings_option_templ[include_file_template][cpt][]" value="%s" %s>%s</label>',
								'taxonomy-'.$taxonomy->name.'-'.esc_attr( $category->slug ).'.php',
								$this->check_template('taxonomy-'.$taxonomy->name.'-'.esc_attr( $category->slug ).'.php')  ? 'checked' : '',
								'taxonomy-'.$taxonomy->name.'-'.esc_attr( $category->slug ).'.php'
							);
						?>
					</li>
					<?php
				}
				?>
				
				
			</ul>
		</div>

		<?php
		endforeach;

	}


	public function page_home_template_callback() {

		wp_dropdown_pages( array(
            'name'              => 'bctheme_settings_option[page_on_front]',
            'show_option_none'  => '&mdash; Seleziona &mdash;',
            'option_none_value' => '0',
            'selected'          => get_option('page_on_front'),
        ) );
		?>
		<br>o crea una nuova pagina per l'homepage:<br>
		<input class="regular-text" type="text" name="bctheme_settings_option[creapagina]" id="creapagina">
		<?php
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
	public function check_template($file){
		$folder_theme = WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet');
		return file_exists($folder_theme.'/'.$file);
	}


	function _limit_depth( $hook ) {
		if ( $hook != 'nav-menus.php' ) return;
		wp_add_inline_script( 'nav-menu', 'wpNavMenu.options.globalMaxDepth = 2;', 'after' );
	}

}


new BcThemeSettings();