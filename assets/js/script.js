$(document).ready(function() {
// Script du Menu Burger //
//code jQuery permet de basculer l'état d'ouverture du menu de navigation (en ajoutant ou supprimant la classe "active") et de modifier l'apparence du bouton burger (en ajoutant ou supprimant la classe "open") lorsque l'utilisateur clique sur le bouton burger.

    $('.burger').click(function(){
        $('nav').toggleClass('active'); //ajoute ou supprime la classe "active" à l'élément <nav>  (Si la classe est absente, elle sera ajoutée, et si elle est présente, elle sera supprimée.)
        $(this).toggleClass('open');    //  ajoute ou supprime la classe "open" à l'élément sur le bouton burger
    });

});