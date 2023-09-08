$(document).ready(function() {
    $('#media-list').DataTable(
        {
            order: [[4, 'desc']],
            pageLength : 10,
            lengthMenu : [10, 20, 30, 40,50],
            language: {
                "lengthMenu": "Afficher _MENU_ media",
                "zeroRecords": "Aucun élément trouvé",
                "info": "Visualisation de _START_ media à _END_ sur _TOTAL_ media",
                "infoEmpty": "Aucun élément disponible",
                "infoFiltered": "(filtré parmi _MAX_ media au total)",
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