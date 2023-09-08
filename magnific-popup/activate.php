<?php
$sanitary_values = array();

$defaultscript = 'function initalilizeMagnificPopup(){' . PHP_EOL;
$defaultscript .= '    jQuery(\'.wp-block-gallery\').each(function() {' . PHP_EOL;
$defaultscript .= '        jQuery(this).magnificPopup({' . PHP_EOL;
$defaultscript .= '            gallery:{enabled:true},' . PHP_EOL;
$defaultscript .= '            preloader: true,' . PHP_EOL;
$defaultscript .= '            delegate: \'a:not(figcaption a)\',' . PHP_EOL;
$defaultscript .= '            type: \'image\',' . PHP_EOL;
$defaultscript .= '            image: {' . PHP_EOL;
$defaultscript .= '                titleSrc: function(item) {' . PHP_EOL;
$defaultscript .= '                    return item.el.siblings(\'figcaption\').html();' . PHP_EOL;
$defaultscript .= '                }' . PHP_EOL;
$defaultscript .= '            },' . PHP_EOL;
$defaultscript .= '            zoom: {' . PHP_EOL;
$defaultscript .= '                enabled: true,' . PHP_EOL;
$defaultscript .= '                easing: \'ease-in-out\',' . PHP_EOL;
$defaultscript .= '                duration: 300, ' . PHP_EOL;
$defaultscript .= '                opener: function(element) {' . PHP_EOL;
$defaultscript .= '                    return element.find(\'img\');' . PHP_EOL;
$defaultscript .= '                }' . PHP_EOL;
$defaultscript .= '            }' . PHP_EOL;
$defaultscript .= '        });' . PHP_EOL;
$defaultscript .= '    });' . PHP_EOL . PHP_EOL;

$defaultscript .= '    jQuery(\'.woocommerce-product-gallery\').magnificPopup({' . PHP_EOL;
$defaultscript .= '        gallery:{enabled:true},' . PHP_EOL;
$defaultscript .= '        delegate: \'a\', ' . PHP_EOL;
$defaultscript .= '        type: \'image\',' . PHP_EOL;
$defaultscript .= '		zoom: {' . PHP_EOL;
$defaultscript .= '			enabled: true,' . PHP_EOL;
$defaultscript .= '            easing: \'ease-in-out\',' . PHP_EOL;
$defaultscript .= '			duration: 300, ' . PHP_EOL;
$defaultscript .= '			opener: function(element) {' . PHP_EOL;
$defaultscript .= '				return element.find(\'img\');' . PHP_EOL;
$defaultscript .= '			}' . PHP_EOL;
$defaultscript .= '		}' . PHP_EOL;
$defaultscript .= '        // other options' . PHP_EOL;
$defaultscript .= '    });' . PHP_EOL;
$defaultscript .= '}' . PHP_EOL;
$defaultscript .= 'initalilizeMagnificPopup();' . PHP_EOL;


$sanitary_values['script_magnificpopup'] = $defaultscript;


add_option('magnificpopup_settings_option', $sanitary_values);

