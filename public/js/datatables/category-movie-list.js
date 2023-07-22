$(document).ready(function() {
    $('#category-movie-list').DataTable(
        {
            pageLength : 10,
            lengthMenu : [10, 20, 30, 40,50],
            language: {
                "lengthMenu": "Afficher _MENU_ Categories de film",
                "zeroRecords": "Aucun élément trouvé",
                "info": "Visualisation de _START_ Categories de film à _END_ sur _TOTAL_ Categories de film",
                "infoEmpty": "Aucun élément disponible",
                "infoFiltered": "(filtré parmi _MAX_ Categories de film au total)",
                "search" : "Rechercher",
                "searchPlaceholder" : "Taper au moins 2 caractères",
                "paginate" : {
                    "previous" : "Précedent",
                    "next" : "Suivant",
                }
            }
        }
    );
});