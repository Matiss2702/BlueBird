const dataTablesFilter = document.querySelector('.dataTables_filter');
const dataTableLength = document.querySelector(".dataTables_length");

if (dataTablesFilter) {
    dataTablesFilter.classList.add("d-flex", "justify-content-lg-end", "pl-3", "pr-lg-3", "pl-lg-0");
}

if (dataTableLength) {
    dataTableLength.classList.add("d-flex", "pl-3");
}