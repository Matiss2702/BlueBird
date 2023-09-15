document.addEventListener('DOMContentLoaded', function() {
    const dropdownMenus = document.querySelectorAll('.dropdown');

    dropdownMenus.forEach((dropdownMenu) => {
        const dropdownToggle = dropdownMenu.querySelector('.dropdown-toggle');
        const dropdownMenuList = dropdownMenu.querySelector('.dropdown-menu');

        dropdownToggle.addEventListener('click', (event) => {
            event.preventDefault();
            dropdownMenuList.classList.toggle('show');
            dropdownToggle.classList.toggle('dropdown-opened');
            dropdownToggle.classList.toggle('dropdown-closed');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownMenu.contains(event.target)) {
                dropdownMenuList.classList.remove('show');
                dropdownToggle.classList.remove('dropdown-opened');
                dropdownToggle.classList.add('dropdown-closed');
            }
        });
    });
});