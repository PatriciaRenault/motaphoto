<?php
// récupere les infos : image mise en avant(thumbnail_url), url du post, titre, categorie, réf
$thumbnail_url = get_the_post_thumbnail_url();
$post_url = get_permalink();
$post_title = get_the_title();
$reference = get_field('reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
/* $categorie_name = $categories[0]->name; */
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $categorie) {
        // Récupérer le nom de chaque catégorie dans $categorie_name
        $categorie_name = $categorie->name;
    }
}
?>
<div class="post-container">
    <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $post_title; ?>">
    <div class="overlay">
        <div class="reference"><?php echo $reference; ?></div>
        <div class="categorie"><?php echo $categorie_name; ?></div>
        <div class="eye-icon">
            <a href="<?php echo $post_url; ?>">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/eye.png'; ?>"
                    alt="Icône oeil">
            </a>
        </div>
        <div class="expand-icon">
            <a class="icon" href=" #" data-reference="<?php echo $reference ?>" data-categorie="<?php echo $categorie_name; ?>" data-thumbnail-url="<?php echo $thumbnail_url; ?>">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
</div>


