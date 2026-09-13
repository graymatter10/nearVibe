document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchRows");

    if (!searchInput) {
        return;
    }

    const table = document.getElementById("eventTable") || document.getElementById("userTable");

    if (!table) {
        return;
    }

    const rows = table.getElementsByTagName("tr");

    searchInput.addEventListener("input", function () {
        const searchText = searchInput.value.toLowerCase().trim();

        for (let i = 1; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            rows[i].style.display = rowText.includes(searchText) ? "" : "none";
        }
    });
});
