<!-- TAXONOMIES ET CHAMPS PERSONNALISES -->
<?php
// Récupération des champs personnalisés avec ACF
	$refPhoto = get_field("reference");       
	$refType = get_field("type");             

// Récupération des taxonomies
	$post = get_the_ID(); //Récupère l'identifiant de la photo.		
	
    $cat = get_the_terms($post, "categorie"); 
	$catname = $cat ? $cat[0]->name : '';  // Si des termes existent, prend le nom du premier terme, sinon une chaîne vide     
	
	$term = get_the_terms($post, "format");   
	$termname = $term ? $term[0]->name : '';  

	$refDate = get_the_date("Y");   	
?>

<?php get_header(); ?>
<div class="container">
<!-- DESCRIPTION DE LA PHOTO -->
<section class="section-single">
	<article class="detail-photo">
        <!-- Affichage des détails de la photo -->
		<div class="description">
			<h2 class="title-photo"><?php the_title() ?></h2>
			<ul>
				<li>référence : <span class="ref"><?php echo esc_html($refPhoto); ?></span></li>
                <li>catégorie : <?php esc_html($catname); ?></li>
                <li>format : <?php esc_html($termname); ?></li>
                <li>type : <?php esc_html($refType); ?></li>
                <li>année : <?php echo esc_html($refDate); ?></li>	
			</ul>
		</div>
        <!-- Affichage de la photo -->
		<div class="affichage-photo">
			<img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
		</div>
	</article>	

<!-- BOUTON CONTACT -->
	<article class="contact_nav">
		<div class="contact">
        	<p>Cette photo vous intéresse ?</p>
            <button class="btn contact btn-contact" data-reference="<?php echo $refPhoto; ?>">Contact</button>
		</div>

<!-- PUBLICATION ACTUELLE ET ADJACENTES --> 
<div class="thumbnail_nav"> 
    <?php
    // Récupération de l'identifiant de la publication actuelle
    $current_post_id = get_the_ID();

    // Récupération des publications adjacentes
    $previous_post = get_adjacent_post(false, '', true);
    $next_post = get_adjacent_post(false, '', false);  
    ?>  

    <!-- Affichage des miniatures des publications adjacentes -->       
    <div class="post-thumbnail">
        <div id="hover-image">
            <?php if ($previous_post): ?>
                <div class="prev-thumbnail">
                    <?php echo get_the_post_thumbnail($previous_post, 'thumbnail'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($next_post): ?>
                <div class="next-thumbnail">
                    <?php echo get_the_post_thumbnail($next_post, 'thumbnail'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Liens vers les publications adjacentes avec flèches -->
    <div class="thumbnail-link">
        <?php if ($previous_post): ?>
            <div class="prev-nav">
                <a href="<?php echo get_permalink($previous_post); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/prev.png'; ?>" alt="Article précédent" class="arrow"/>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($next_post): ?>
            <div class="next-nav">
                <a href="<?php echo get_permalink($next_post); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/next.png'; ?>" alt="Article suivant" class="arrow"/>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
	</article>
</section>
<!-- PHOTOS APPARENTEES -->
<section class="section_apparentees">
<h3>vous aimerez aussi</h3>
    <div class="photos_list">
        <?php 
        // Récupére la catégorie de la photo actuellement affichée
        $current_categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'slugs'));   //tableau contenant les slugs des catégories associées à l'article courant
        $current_categories = $current_categories ? $current_categories : array();  // soit un tableau de slugs des catégories associées à l'article, soit un tableau vide si aucune catégorie n'est associée à l'article

        $current_post_id = get_the_ID(); // Récupère l'ID du post actuel
        
         // pour récupérer deux posts aléatoires de type 'photos'de mêmes catégories, en excluant le post actuel 
         $args = array(
            'post_type' => 'photos',
            'orderby' => 'rand',
            'posts_per_page' => 2,
            'post__not_in' => array($current_post_id),     // Exclure le post actuel de la liste
            'tax_query' => array(
                array(                                     
                    'taxonomy' => 'categorie',             
                    'field' => 'slug',                     
                    'terms' => $current_categories,        // tableau de slugs recuperé auparavant
                ),
            ),
        );        
        // On exécute la WP Query
        $my_query = new WP_Query( $args );

       // lance la boucle 
        if( $my_query->have_posts() ) :                            // Vérifie s'il y a des posts correspondant à la requête.
            while( $my_query->have_posts() ) :                     
                $my_query->the_post();                             // Définit les données du post courant.
                get_template_part( 'template-parts/photo_block' ); 
            endwhile;
        endif;
         
        // On réinitialise à la requête principale 
        wp_reset_postdata();
        ?>
    </div>  
</section>
</div>
<?php get_footer(); ?>