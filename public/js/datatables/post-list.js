$(document).ready(function() {
    $('#post-list').DataTable(
        {
            pageLength : 10,
            lengthMenu : [10, 20, 30, 40,50],
            language: {
                "lengthMenu": "Afficher _MENU_ articles",
                "zeroRecords": "Aucun élément trouvé",
                "info": "Visualisation de _START_ articles à _END_ sur _TOTAL_ articles",
                "infoEmpty": "Aucun élément disponible",
                "infoFiltered": "(filtré parmi _MAX_ articles au total)",
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