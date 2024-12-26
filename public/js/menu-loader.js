$(document).ready(function () {

    function loadMenu(urli) {


        $.ajax({
            url: urli, // Route définie dans le contrôleur
            method: 'GET',
            success: function (response) {
                $('#content').html(response); // Injecte le contenu dans le conteneur
            },
            error: function (e) {
                console.error('Erreur AJAX :', e);
        alert('Une erreur est survenue lors du chargement du menu : ' + e.status + ' ' + e.statusText);
            }
        });
    }
    var url = "/utilisateur"
    // Charger le menu au chargement de la page
    loadMenu(url);
    
    // Exemple : Recharger le menu sur un clic
    $('.menu-link').click(function (e) {
        e.preventDefault();
       var url =  $(this).attr("href")
       console.log(url)
        loadMenu(url);
    });
});
