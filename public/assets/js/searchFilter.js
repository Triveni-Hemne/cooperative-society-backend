document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase(); // Get the search input value in lowercase
    let rows = document.querySelectorAll("#tableFilter tbody tr"); // Get all table rows

    rows.forEach(row => {
        let text = row.innerText.toLowerCase(); // Get the row's text content in lowercase
        row.style.display = text.includes(filter) ? "" : "none"; // Show/Hide row based on match
    });
});