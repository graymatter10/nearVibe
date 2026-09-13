document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('searchRows');
    var eventTable = document.getElementById('eventTable');

    if (!searchInput || !eventTable) {
        return;
    }

    searchInput.addEventListener('input', function () {
        var searchText = searchInput.value.toLowerCase().trim();
        var rows = eventTable.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) {
            var eventNameCell = rows[i].getElementsByTagName('td')[1];

            if (eventNameCell) {
                var eventName = eventNameCell.textContent.toLowerCase();

                if (eventName.indexOf(searchText) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });
});
