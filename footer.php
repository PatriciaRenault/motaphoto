</main>

<footer class="navfooter">
    <div class="navfooter__menu">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'footer', 
                'container' => 'ul', 
                'menu_class' => 'menu-footer',
            ));
            ?>
        <p>TOUT DROITS RÉSERVÉS</p>
       
    </div>
</div>
 <!-- integration de la popup de contact  -->
 <?php get_template_part('/template-parts/modal');?>
</footer>

<?php wp_footer(); ?>

</body>
</html>