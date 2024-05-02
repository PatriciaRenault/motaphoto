<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article class="post">
                <?php the_post_thumbnail(); ?>

                <h1><?php the_title(); ?></h1>

                <div class="post__meta">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                    <p>
                        Publié le <?php the_date(); ?>
                        par <?php the_author(); ?>
                        Dans la catégorie <?php the_category(); ?>
                        Avec les étiquettes <?php the_tags(); ?>
                    </p>
                </div>

                <div class="container post__content">
                    <?php the_content(); ?>
                </div>
            </article>

    <?php endwhile;
    endif; ?>

</main>

<?php get_footer(); ?>