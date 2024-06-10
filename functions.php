<?php
 
//AJOUTE DIVERSES FONCTIONNALITES DE SUPPORT AU THEME WORPRESS
function montheme_supports()
{
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
   
}
add_action('after_setup_theme', 'montheme_supports');

// ENREGISTREMENT DES STYLES ET DES SCRIPTS
function enqueue_motaphoto_assets() {

    // Enqueue le style principal du thème
    wp_enqueue_style('motaphoto-style', get_template_directory_uri() . '/style.css', array(), '1.0');

    // Enqueue le script pour la lightbox avec jQuery comme dépendance
    wp_enqueue_script('lightbox-scripts', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true);

    // Enqueue le script principal du thème
    wp_enqueue_script('motaphoto-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery', 'lightbox-scripts'), '1.0', true);

    // Ajout de la configuration AJAX pour les boutons "Charger plus"
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), '1.0', true);

    // Enregistrement du script ajax-filter pour gérer les filtres AJAX
    wp_enqueue_script('ajax-filter', get_template_directory_uri() . '/assets/js/filter.js', array('jquery'), '1.0', true);

    // Localize le script AJAX pour passer l'URL de l'admin AJAX de WordPress
    wp_localize_script('ajax-filter', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_assets');


// FONCTION POUR ENREGISTRER LES MENUS DE NAVIGATION
function register_my_menus() {
    register_nav_menus( array(
        'header' => 'Menu principal',      
        'footer' => 'Menu pied de page',  
    ) );
}
add_action( 'init', 'register_my_menus' );  



// FONCTION CHARGEMENT DES POSTS SUPPLEMENTAIRES
function load_more_photos() {
    //arguments de la requête pour récupérer les photos
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => isset($_POST['paged']) ? intval($_POST['paged']) : 1,  // Numéro de la page actuelle
    );

    // Ajout des filtres par catégorie
    if (isset($_POST['category_filter']) && $_POST['category_filter']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['category_filter']),
        );
    }
    // Ajout des filtres par format
    if (isset($_POST['format_filter']) && $_POST['format_filter']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['format_filter']),//Nettoie l'entrée pour prévenir les attaques XSS et autres.
        );
    }
    //récupère les publications de type 'photos' avec les arguments choisis
    $query = new WP_Query($args);    

    $response = '';// Variable pour stocker le contenu généré par la boucle
    $max_pages = $query->max_num_pages;  //récupère le nombre maximum de pages de la requête
    
    if ($query->have_posts()) {
        ob_start(); //démarre la mise en mémoire tampon de sortie 
        
        // Boucle pour parcourir toutes les publications récupérées par la requête WP_Query
        while ($query->have_posts()) {
            $query->the_post();
            // Récupère le contenu HTML généré à partir du modèle 'photo_block' pour chaque photo récupérée, et l'ajoute à `$response`.
            $response .= get_template_part('template-parts/photo_block');
        }

        //Récupére le HTML généré et nettoie la mémoire tampon
        $response = ob_get_clean();       
    }

    // tableau contenant le nombre de pages et le code html
    $result = array(
        'max' => $max_pages,
        'html' => $response,
    );

    // Encodage en JSON du tableau résultat
    echo json_encode($result);  
    exit;// Arrête l'exécution du script
}

// Action WordPress pour la requête AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


//FONCTION POUR LES FILTRES
function filter_photos() {
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged'=> currentPage 
    );
    // Filtre par catégorie : on ajoute un critère de taxonomie pour filtrer les photos par catégorie en utilisant le slug de la catégorie.
    if (isset($_GET['category_filter']) && $_GET['category_filter']) {      
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['category_filter']),// Utilise la valeur nettoyée
            ),
        );
    }

    // Filtre par format : On ajoute une condition de taxonomie pour filtrer les éléments par format
    if (isset($_GET['format_filter']) && $_GET['format_filter']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['format_filter']),
        );
    }

    // Tri : on définit le tri par défaut par date et ajuste l'ordre selon la valeur de sort_order.
    if (isset($_GET['sort_order'])) {
        $args['orderby'] = 'date';  
        if ($_GET['sort_order'] == 'date-ASC') {
            $args['order'] = 'ASC';
        } else if ($_GET['sort_order'] == 'date-DESC') {
            $args['order'] = 'DESC';
        }
    }

    // Exécute la requête WP_Query avec les arguments définis
    $query = new WP_Query($args);
    $response = '';
    // Charge le template pour chaque photo
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) :
            $query->the_post();
            get_template_part('template-parts/photo_block', 'photo');
        endwhile;
        $response = ob_get_contents();
        ob_end_clean(); //// Récupère et nettoie le contenu mis en tampon
    }
    // Retourne la réponse au format JSON
    echo json_encode(array('html' => $response));
    exit;
}
// Action WordPress pour la requête AJAX
add_action('wp_ajax_filter_photos', 'filter_photos'); 
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos'); 

?>