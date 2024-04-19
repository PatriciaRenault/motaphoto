<?php
add_theme_support('custom-logo');

// Liens avec les styles et les scripts
function enqueue_motaphoto_styles() {
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '1.0');
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0', true);
}

// Action pour ajouter la fonction à la file d'attente des styles
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_styles');



// Fonction pour enregistrer les menus de navigation
function register_my_menus() {
    register_nav_menus( array(
        'header' => 'Menu principal',      // Menu de navigation de l'en-tête
        'footer' => 'Menu pied de page',  // Menu de navigation du pied de page
    ) );
}
add_action( 'init', 'register_my_menus' );  // Action pour enregistrer les menus lors de l'initialisation de WordPress
?>