(function ($) {

  let loading = false; // Indique si le chargement est en cours ou non
  const $loadMoreButton = $('#load-more-button'); // Sélectionne le bouton "Charger plus"
  const $container = $('.photos_list'); // Sélectionne le conteneur de vignettes

  $loadMoreButton.on('click', function () {
    get_more_posts(true); // Appelle la fonction pour obtenir plus de publications
});


  // Définition de la fonction get_more_posts
  function get_more_posts(load) {
      let inputPage = $('input[name="page"]');
      console.log(load);
      let page = parseInt(inputPage.val());
      page = load ? page + 1 : 1; // Incrémente le numéro de page si "load" est vrai, sinon réinitialise à 1.
      const category = $('select[name="category-filter"]').val();
      const format = $('select[name="format-filter"]').val();
      const dateSort = $('select[name="date-sort"]').val();

      console.log(category, format, dateSort, page);

      $.ajax({
          type: 'GET',
          url: wp_data.ajax_url, // Ceci est défini dans functions.php avec wp_localize_script
          data: {
              action: 'load_more_posts',
              page: page,
              category: category,
              format: format,
              date_sort: dateSort
          },

          success: function (response) {

              if (response) {
               
                  if (load) {
                      $container.append(response); // Ajoute la réponse (nouvelles publications) au conteneur
                  } else {
                      $container.html(response); // Remplace le contenu du conteneur par la réponse (nouvelles publications)
                  }
                  $('#load-more-button').text('Charger plus'); // Remet le texte du bouton à "Charger plus"
                  inputPage.val(page); // Met à jour le numéro de page
                  loading = false; // Indique que le chargement est terminé
              } else {
                  if (load) {
                      $('#load-more-button').text('Fin des publications'); // Change le texte du bouton en "Fin des publications"
                  } else {
                      let txt = '<div style="text-align:center;width:100%; color: #000;font-family: Space Mono, monospace;font-size: 16px;"><p>Aucun résultat ne correspond aux filtres de recherche.<br>';
                      $('#container').html(txt); // Affiche un message si aucune réponse n'est trouvée
                  }
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {
              console.error('Erreur AJAX : ' + textStatus + ' : ' + errorThrown);
              $('#load-more-button').text('Charger plus'); // Remet le texte du bouton à "Charger plus" en cas d'erreur
              loading = false; // Réinitialise le statut de chargement
          }
      });

      if (!loading) {
          loading = true;
          $('#load-more-button').text('Chargement en cours...'); // Change le texte du bouton en "Chargement en cours..."
      }
  }

 
})(jQuery);
