<?php
class BcThemeSettingsTemplate extends BcThemeSettings {
    
    public function bctheme_settings_page_init() {
        register_setting(
            'bctheme_settings_option_group', // option_group
            'bctheme_settings_option', // option_name
            array( $this, 'bctheme_settings_sanitize' ) // sanitize_callback
        );
        add_settings_section(
			'bctheme_settings_section', // id
			'', // title
			'', // callback
			'bctheme-settings' // page
		);
        
        add_settings_field(
            'include_file_template', // id
            'File template', // title
            array( $this, 'include_file_template_callback' ), // callback
            'bctheme-settings', // page
            'bctheme_settings_section' // section
        );

        
    }
    public function bctheme_settings_sanitize($input) {
        $folder_theme = WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet' );

        if ( isset( $input['include_file_template']['generic'] ) ) {
            //$sanitary_values['include_file_template'] = $input['include_file_template'];
            //$this->check_template('archive.php')
            //$this->copyfile(PLUGIN_THEME_DIR  . 'file_theme/dynamic/archive.php', $folder_theme . '/template_homepage.php');
            
            if(is_array($input['include_file_template']['generic'])) {
                foreach($input['include_file_template']['generic'] as $file ){
                    if(!$this->check_template($file)){
                        $this->copyfile(PLUGIN_THEME_DIR  . 'file_theme/dynamic/'.$file, $folder_theme . '/'.$file);
                    }
                }
            }
        }
        if ( isset( $input['include_file_template']['cpt'] ) ) {
            //$sanitary_values['include_file_template'] = $input['include_file_template'];
            //$this->check_template('archive.php')
            //$this->copyfile(PLUGIN_THEME_DIR  . 'file_theme/dynamic/archive.php', $folder_theme . '/template_homepage.php');
            
            if(is_array($input['include_file_template']['cpt'])) {
                foreach($input['include_file_template']['cpt'] as $file ){
                    if(!$this->check_template($file)){
                        $sourcT = explode("-",$file)[0];
                        $this->copyfile(PLUGIN_THEME_DIR  . 'file_theme/dynamic/'.$sourcT.'.php', $folder_theme . '/'.$file);
                    }
                }
            }
        }
    }



    public function include_file_template_callback() {
		/*printf(
			'<input type="checkbox" name="bctheme_settings_option[include_file_template]" id="include_file_template" value="include_file_template" %s>',
			( isset( $this->bctheme_settings_options['include_file_template'] ) && $this->bctheme_settings_options['include_file_template'] === 'include_file_template' ) ? 'checked' : ''
		);*/

		?>

		<div>
			<strong>Generic template</strong>
			<ul>
			<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][generic][]" value="archive.php" %s>%s</label>',
							$this->check_template('archive.php')  ? 'checked' : '',
							'archive.php'
						);
					?>
				</li>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][generic][]" value="single.php" %s>%s</label>',
							$this->check_template('single.php')  ? 'checked' : '',
							'single.php'
						);
					?>
				</li>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][generic][]" value="404.php" %s>%s</label>',
							$this->check_template('404.php')  ? 'checked' : '',
							'404.php'
						);
					?>
				</li>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][generic][]" value="search.php" %s>%s</label>',
							$this->check_template('search.php')  ? 'checked' : '',
							'search.php'
						);
					?>
				</li>
				<li>
				<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][generic][]" value="taxonomy.php" %s>%s</label>',
							$this->check_template('taxonomy.php')  ? 'checked' : '',
							'taxonomy.php'
						);
					?>
				</li>
			</ul>
		</div>

		<?php
		$args_custom_post_types = array(
			'public' => true,
			'_builtin' => false
		);
		$custom_post_types = get_post_types( $args_custom_post_types, 'objects' );
		foreach ( $custom_post_types as $post_type_obj ):
			
			$labels = get_post_type_labels( $post_type_obj );
			/*echo '<label><input type="checkbox" name="bc_settings_cf[include_file_template][]" value="'.esc_attr( $post_type_obj->name ).'" ';
			echo ( isset( $v['typepost'] ) && in_array(esc_attr( $post_type_obj->name ), $v['typepost']) ) ? 'checked' : '';
			echo '> '.esc_html( $labels->name ).' </label>';*/
		?>

		<div>
			<strong><?php echo esc_html( $labels->name ); ?></strong>
			<ul>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][cpt][]" value="%s" %s>%s</label>',
							'archive-'.esc_attr( $post_type_obj->name ).'.php',
							$this->check_template('archive-'.esc_attr( $post_type_obj->name ).'.php')  ? 'checked' : '',
							'archive-'.esc_attr( $post_type_obj->name ).'.php'
						);
					?>
				</li>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][cpt][]" value="%s" %s>%s</label>',
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
			$args = array(
				'public'   => true,
				'_builtin' => false
				
			  ); 
		foreach ( get_taxonomies($args,'objects') as $taxonomy ):
			?>
		<div>
			<strong><?php echo esc_html( $taxonomy->label ); ?></strong>
			<ul>
				<li>
					<?php
						printf(
							'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][cpt][]" value="%s" %s>%s</label>',
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
					?>
					<li>&nbsp&nbsp&nbsp&nbsp&nbsp
						<?php
							printf(
								'<label><input type="checkbox" name="bctheme_settings_option[include_file_template][cpt][]" value="%s" %s>%s</label>',
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

    public function check_template($file){
		$folder_theme = WP_CONTENT_DIR  . '/themes/' . get_option( 'stylesheet');
		return file_exists($folder_theme.'/'.$file);
	}
	
}