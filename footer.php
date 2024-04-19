
< <footer>
            <!-- Menu secondaire -->
            <div class="navfooter__menu">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'footer', 
                'container' => false, 
                'menu_class' => 'menu',
            ));
            ?>
    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>