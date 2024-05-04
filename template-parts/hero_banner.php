<!-- Bloc d'affichage d'une photo de la liste pour page accueil -->

<div class="banner-style">
<?php
        $post_id = 59; // ID du post pour afficher son image dans la bannière
        $thumbnail_banner = get_the_post_thumbnail_url($post_id);  //Récupère l'URL de l'image mise en avant (miniature) du post 

        if ($thumbnail_banner) {                                   //si une URL d'image a été récupérée avec succès
?>
            <img src="<?php echo $thumbnail_banner; ?>" alt="<?php echo  get_the_title($post_id); ?>">   <!--Affiche l'image de la bannière en utilisant l'URL -->

<?php 
} 
?>
    <div class="titre-header">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/titreHeader.png'; ?>" alt="Photographe event">      <!--Affiche l'image du titre -->
    </div>
    
        
        

</div>