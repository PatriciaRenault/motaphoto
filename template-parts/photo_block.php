<!-- recuperation des elements---->
<?php
// Récupère l'URL de l'image mise en avant
$thumbnail_url = get_the_post_thumbnail_url();

// Récupère l'URL du post
$post_url = get_permalink();

// Récupère le titre du post
$post_title = get_the_title();

// Récupère la référence (en supposant que c'est un champ personnalisé)
$reference = get_field('reference');

// Récupère les catégories du post
$categories = get_the_terms(get_the_ID(), 'categorie');

// Initialise une variable pour stocker les noms des catégories
$categories_names = '';

// Vérifie si des catégories existent et s'il n'y a pas d'erreur
if ($categories && !is_wp_error($categories)) {
    // Parcourt chaque catégorie pour récupérer son nom
    foreach ($categories as $categorie) {
        // extraire le nom de chaque catégorie et le stocke dans la variable $categorie_name.
        $categorie_name = $categorie->name;
    }
}
?>
<!--afficher les informations de chaque publication dans une mise en page de type galerie-->
<div class="post-container">
    <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $post_title; ?>">
    <div class="overlay">
        <div class="reference"><?php echo $reference; ?></div>
        <div class="categorie"><?php echo $categorie_name; ?></div>
        <!--icône d'œil  lien vers la publication -->
        <div class="eye-icon">
            <a href="<?php echo $post_url; ?>">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/eye.png'; ?>"
                    alt="Icône oeil">
            </a>
        </div>
        <!-- icône de plein écran -->
        <div class="expand-icon">
        <img class="icon-fullscreen"
                    src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png'; ?>"
                    alt="Icône Fullscreen">
            </a>
        </div>
    </div>
</div>


