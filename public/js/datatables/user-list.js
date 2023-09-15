$(document).ready(function() {
    $('#user-list').DataTable(
        {
            pageLength : 10,
            lengthMenu : [10, 20, 30, 40,50],
            language: {
                "lengthMenu": "Afficher _MENU_ utilisateurs",
                "zeroRecords": "Aucun élément trouvé",
                "info": "Visualisation de _START_ utilisateurs à _END_ sur _TOTAL_ utilisateurs",
                "infoEmpty": "Aucun élément disponible",
                "infoFiltered": "(filtré parmi _MAX_ utilisateurs au total)",
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