jQuery(document).ready(function ($) {
  
  console.log(ajax_object.ajaxurl);
  // Lorsqu'une valeur est sélectionnée dans le formulaire
  $("#filter-form select").change(function (event) {             //ecouteur des changements dans les listes deroulante du formulaire filter-form
    var category = $('select[name="category_filter"]').val();    // recupere la valeur de la categorie selectionnée
    var format = $('select[name="format_filter"]').val();        // recupere la valeur du format selectionné
    var order = $('select[name="sort_order"]').val();            // recupere la valeur du tri souhaité

    //  requête AJAX vers le serveur en utilisant les données de filtrage sélectionnées par l'utilisateur.
    $.ajax({
      type: "GET",
      url: afp_vars.afp_ajax_url,  //Spécifie l'URL vers laquelle la requête AJAX sera envoyée. Cette URL est stockée dans la variable afp_vars.afp_ajax_url et contient généralement l'URL vers le point d'accès AJAX de WordPress (admin-ajax.php).
      dataType: "json",            //jQuery interprétera automatiquement la réponse de la requête AJAX comme étant un objet JSON.
      data: {
        action: "filter_photos",  //Spécifie l'action à effectuer côté serveur.
        category_filter: category,
        format_filter: format,
        sort_order: order,
      },
    
      // en cas de succes, le contenu de l'élément .photos_list est remplacé par le contenu HTML retourné par le serveur
      success: function (response) {
        // Pour voir toute la réponse
        $(".photos_list").empty().html(response.html);
        //initLightbox(); 
        event.preventDefault();  //empeche le rechargement du formulaire
      },
    });
  });
});
