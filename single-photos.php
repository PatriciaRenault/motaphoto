
<!-- recuperation des variables des taxonimies et des champs personnalisés -->
<?php
// recuperer les custom fields avec ACF
	$refPhoto = get_field("reference");       //Récupère la valeur du champ personnalisé "reference" de la photo.
	$refType = get_field("type");             //Récupère la valeur du champ personnalisé "type" de la photo.

// Champs de Taxonomies
	$post = get_the_ID(); //Récupère l'identifiant de la photo.	
	
	$cat = get_the_terms($post, "categorie"); //Récupère un tableau contenant les termes de la taxonomie "categorie" de la photo.
	$catname = $cat[0]->name;       //Récupère la catégorie de la photo
	
	$term = get_the_terms($post, "format");   //Récupère un tableau contenant les termes de la taxonomie "format" de la photo.
	$termname = $term[0]->name;   //Récupère le format de la photo 

	$refDate = get_the_date("Y");   //Récupère l'année de la publication de la photo.
	
	
?>

<?php get_header(); ?>

<section class="section-single">
<!-- afficher les détails d'une photo dans la page -->
	<article class="detail-photo">
		<div class="description">
			<h2 class="title-photo"><?php echo the_title() ?></h2>
			<ul>
				<li>référence : <span class="ref"><?php echo $refPhoto; ?></li>
                <li>catégorie : <?php echo $catname; ?></li>
                <li>format : <?php echo $termname; ?></li>
                <li>type : <?php echo $refType; ?></li>
                <li>année : <?php echo $refDate; ?></li>	
			</ul>
		</div>

		<div class="affichage-photo">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>">
		</div>
	</article>	
<!-- bouton contact -->
	<article class="contact_nav">
		<div class="contact">
        	<p>Cette photo vous intéresse ?</p>
        	<button class="btn contact btn-contact " data-reference="<?php echo $reference; ?>">Contact</button>
		</div>
<!-- .Récupération des informations sur la publication actuelle et ses publications adjacentes    --> 
		<div class="thumbnail_nav"> 
            <?php
            // Récupère l'ID du post actuel
            $current_post_id = get_the_ID();
            // Récupère le post précédent
            $previous_post = get_adjacent_post(false, '', true);
            // Récupère le post suivant
            $next_post = get_adjacent_post(false, '', false);  
            ?>  
                     
            <div class="post-thumbnail">
                <div id="hover-image">
                    <div class="prev-thumbnail">
                        <?php echo get_the_post_thumbnail($previous_post, 'thumbnail'); ?>
                    </div>
                    <div class="next-thumbnail">
                        <?php echo get_the_post_thumbnail($next_post, 'thumbnail'); ?>
                    </div>
                </div>
            </div>
            <div class="thumbnail-link">
            <?php
            // Affiche la miniature du post précédent s'il existe
            if ($previous_post) {
                ?>
                <div class="prev-nav">
                    <a href="<?php echo get_permalink($previous_post); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri($previous_post) . '/assets/images/prev.png' ?>" alt="Article précédent" class="arrow"/>
                    </a>
                </div>
                <?php
            }
            // Affiche la miniature du post suivant s'il existe
            if ($next_post) {
                ?>
                <div class="next-nav">
                    <a href="<?php echo get_permalink($next_post); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri($next_post) . '/assets/images/next.png' ?>" alt="Article suivant" class="arrow"/>
                    </a>
                </div>
                <?php
            } 
            ?>
            </div>
		</div>
	</article>
</section>

<?php get_footer(); ?>