document.addEventListener("DOMContentLoaded", function () {
    console.log("hello from delete modal");

    let deleteForm = document.getElementById("deleteForm");

    // Handle "Delete" button click
    document.querySelectorAll(".text-decoration-none").forEach((button) => {
        button.addEventListener("click", function () {
            let route = this.getAttribute("data-route");
            let name = this.getAttribute("data-name");

            // Set form action dynamically
            deleteForm.setAttribute("action", route);
            deleteMessage.textContent = `Are you sure you want to delete the record about "${name}"? This action cannot be undone.`;
        });
    });
});
