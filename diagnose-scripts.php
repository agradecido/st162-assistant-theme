<?php
/**
 * Archivo de diagnóstico para identificar scripts problemáticos
 * Temporalmente agregar al functions.php o ejecutar directamente
 */

// Función para listar todos los scripts enqueueados
function debug_enqueued_scripts() {
    global $wp_scripts;
    
    echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
    echo '<h3>Scripts Enqueueados:</h3>';
    
    if (isset($wp_scripts->queue)) {
        foreach ($wp_scripts->queue as $handle) {
            if (isset($wp_scripts->registered[$handle])) {
                $script = $wp_scripts->registered[$handle];
                echo '<strong>' . $handle . '</strong>: ' . $script->src . '<br>';
                
                // Verificar si contiene los archivos problemáticos
                if (strpos($script->src, 'sass.dart.js') !== false) {
                    echo '<span style="color: red;">⚠️ SASS.DART.JS ENCONTRADO!</span><br>';
                }
                if (strpos($script->src, 'immutable.es.js') !== false) {
                    echo '<span style="color: red;">⚠️ IMMUTABLE.ES.JS ENCONTRADO!</span><br>';
                }
                if (strpos($script->src, 'chatbot.js') !== false) {
                    echo '<span style="color: red;">⚠️ CHATBOT.JS ENCONTRADO!</span><br>';
                }
            }
        }
    }
    
    echo '</div>';
}

// Función para listar todos los plugins activos
function debug_active_plugins() {
    echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
    echo '<h3>Plugins Activos:</h3>';
    
    $active_plugins = get_option('active_plugins');
    foreach ($active_plugins as $plugin) {
        echo $plugin . '<br>';
    }
    
    echo '</div>';
}

// Agregar al hook wp_footer para mostrar el debug
add_action('wp_footer', function() {
    if (current_user_can('administrator')) {
        debug_enqueued_scripts();
        debug_active_plugins();
    }
});
