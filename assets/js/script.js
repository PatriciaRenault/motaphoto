$(document).ready(function() {

/*********** GESTION DU MENU BURGER ***************/  

$('.burger').click(function() {    
    $('nav').toggleClass('active');    //pour afficher le menu burger
    $(this).toggleClass('open');       //pour transformer le bouton burger en croix ou en ligne
});


/*********** GESTION DE LA MODALE ***************/

    // Récupération des éléments du DOM
    let modal = document.getElementById('myModal');
    let linkContact = document.getElementById("menu-item-251");

    // Vérification que les éléments existent avant de les utiliser
    if (modal && linkContact) {
        // Ouverture de la modale au clic sur le lien de contact
        linkContact.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "block";
        };

        // Fermeture de la modale au clic n'importe où à l'extérieur
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Récupération du bouton d'activation de la modale
        let btn = document.querySelector('.contact');
        if (btn) {
            // Ouverture de la modale au clic sur le bouton
            btn.onclick = function() {
                modal.style.display = "block";
            };

            // Pré-remplissage automatique du champ "RÉF. PHOTO" au clic sur le bouton de contact
            const refPhoto = document.querySelector('.ref').textContent;
            const btnCon = document.querySelector('.btn-contact');
            const inputRef = document.querySelector('#refphoto');

            // Vérification que les éléments existent avant d'ajouter un événement
            if (btnCon && inputRef) {
                btnCon.addEventListener('click', function() {
                    inputRef.value = refPhoto;
                });
            }
        }
    }

    /*********** GESTION DE LA MINIATURE DANS SINGLE_PHOTO ***************/

    // Cache toutes les miniatures lors du chargement de la page
    $('.prev-thumbnail').hide();
    $('.next-thumbnail').hide();

    // Gère l'affichage des miniatures au survol
    $('.prev-nav').hover(
        function() {
            // Lorsque l'on survole la flèche précédente, affiche la miniature
            $('.prev-thumbnail').show();
        }, 
        function() {
            // Lorsque l'on arrête de survoler la flèche, cache la miniature
            $('.prev-thumbnail').hide();
        }
    );

    $('.next-nav').hover(
        function() {
            // Lorsque l'on survole la flèche suivante, affiche la miniature
            $('.next-thumbnail').show();
        }, 
        function() {
            // Lorsque l'on arrête de survoler la flèche, cache la miniature
            $('.next-thumbnail').hide();
        }
    );
    
});