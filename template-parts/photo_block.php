<!-- recuperation des elements---->
<?php
$thumbnail_url = get_the_post_thumbnail_url();// URL de l'image mise en avant
$post_url = get_permalink(); //URL du post
$post_title = get_the_title();
$reference = get_field('reference');
$categories = get_the_terms(get_the_ID(), 'categorie');

// Initialise une variable pour stocker les noms des catégories
$categories_names = '';

// Vérifie si des catégories existent et s'il n'y a pas d'erreur
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $categorie) {
        // extrait le nom de chaque catégorie et le stocke dans la variable $categorie_name.
        $categorie_name = $categorie->name;
    }
}
?>
<!--affiche les informations de chaque publication dans une mise en page de type galerie-->
<div class="post-container">
    <div class="photo-thumbnail">
    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
        <div class="overlay">
            <div class="reference"><?php echo esc_html($reference); ?></div>
            <div class="categorie"><?php echo esc_html($categorie_name); ?></div>

            <!--icône d'œil  lien vers la publication -->
            <div class="eye-icon">
                <a href="<?php echo esc_url($post_url); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/eye.png'); ?>" 
                       alt="Icône oeil">
                </a>
            </div>

            <!-- icône de plein écran -->
            <div class="expand-icon">
                <img class="icon-fullscreen"
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Icon_fullscreen.png'); ?>"
                     alt="Icône Fullscreen">
            </div>
        </div>
    </div>
</div>


