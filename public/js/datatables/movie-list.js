$(document).ready(function() {
    $('#movie-list').DataTable(
        {
            pageLength : 10,
            lengthMenu : [10, 20, 30, 40,50],
            language: {
                "lengthMenu": "Afficher _MENU_ films",
                "zeroRecords": "Aucun élément trouvé",
                "info": "Visualisation de _START_ films à _END_ sur _TOTAL_ films",
                "infoEmpty": "Aucun élément disponible",
                "infoFiltered": "(filtré parmi _MAX_ films au total)",
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