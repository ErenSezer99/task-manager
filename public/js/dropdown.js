document.addEventListener('DOMContentLoaded', function() {
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.map(function(dropdownToggleEl) {
        new bootstrap.Dropdown(dropdownToggleEl);
    });
});
