$(document).ready(function() {

/*********** GESTION DU MENU BURGER ***************/  

//code jQuery permet de basculer l'état d'ouverture du menu de navigation (en ajoutant ou supprimant la classe "active") et de modifier l'apparence du bouton burger (en ajoutant ou supprimant la classe "open") lorsque l'utilisateur clique sur le bouton burger.

    $('.burger').click(function(){
        $('nav').toggleClass('active'); //ajoute ou supprime la classe "active" à l'élément <nav>  (Si la classe est absente, elle sera ajoutée, et si elle est présente, elle sera supprimée.)
        $(this).toggleClass('open');    //  ajoute ou supprime la classe "open" à l'élément sur le bouton burger
    });



/*********** GESTION DE LA MODALE ***************/

    let modal = document.getElementById('myModal');
    let linkContact = document.getElementById("menu-item-42");
    
    // Ouverture de la modale au clic
    linkContact.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    }

    //Fermeture de la modale au clic n'importe où à l'extérieur
    window.onclick = function(event) {
       if (event.target == modal) {
          modal.style.display = "none";
       }
    }

    // Activation bouton de la modale
    var btn = document.querySelector('.contact');

    // Ouverture de la modale au clic
    if(btn){
        btn.onclick = function() {
            modal.style.display = "block";
        }
    
    // rempli automatiquement le champ RÉF. PHOTO 

        const refPhoto = document.querySelector('.ref').textContent;
        const btnCon = document.querySelector('.btn-contact');
        const inputRef = document.querySelector('#refphoto');
        btnCon.addEventListener('click', function(){
            inputRef.value = refPhoto;
        });

    }

/*********** GESTION DE LA MINIATURE DANS SINGLE_PHOTO ***************/


    // Cache toutes les miniatures lors du chargement de la page
    $('.prev-thumbnail').hide();
    $('.next-thumbnail').hide();

    // Gére l'affichage des miniatures au survol
    $('.prev-nav').hover(function() {
        // Lorsque l'on survol la fleche precedente
        $('.prev-thumbnail').show(); // Affiche l'élément avec la classe 'prev-thumbnail' cad la photo precedente
    }, function() {
        // Lorsque l'on arrete de survoler la fleche
        $('.prev-thumbnail').hide(); // Masque la photo precedente
    });
    

    $('.next-nav').hover(function() {
        // Lorsque l'on survol la fleche suivante
        $('.next-thumbnail').show(); // Affiche l'élément avec la classe 'next-thumbnail' c'est a dire la photo suivante
    }, function() {
        // Lorsque l'on arrete de survoler la fleche
        $('.next-thumbnail').hide(); // on masque la photo suivante
    });
    
});