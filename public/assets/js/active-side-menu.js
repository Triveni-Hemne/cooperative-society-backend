document.addEventListener("DOMContentLoaded", function () {
    console.log("helloooooo");
    const currentLocation = window.location.pathname;
    const menuLinks = document.querySelectorAll(".side-link");

    menuLinks.forEach((link) => {
        const linkPath = new URL(link.href).pathname;

        if (linkPath === currentLocation) {
            link.classList.add("active-side-link");

            // Start climbing up to all accordion-collapse parents
            let currentCollapse = link.closest(".accordion-collapse");

            while (currentCollapse) {
                currentCollapse.classList.add("show");

                // Get the button that controls this collapse section
                const collapseId = currentCollapse.getAttribute("id");
                const button = document.querySelector(
                    `[data-bs-target="#${collapseId}"]`
                );

                if (button) {
                    button.classList.remove("collapsed");
                }

                // Move up to the next parent accordion
                currentCollapse = currentCollapse
                    .closest(".accordion")
                    .closest(".accordion-collapse");
            }
        }
    });
});
