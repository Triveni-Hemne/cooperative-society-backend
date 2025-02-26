// !-- JavaScript to Keep Accordion Open Based on URL -->

console.log("hello");

const currentLocation = window.location.pathname;
const menuLinks = document.querySelectorAll(".side-link");

menuLinks.forEach((link) => {
    const linkPath = new URL(link.href).pathname; // Get the pathname part of the URL

    if (linkPath === currentLocation) {
        link.classList.add("active-side-link");

        // Find closest accordion collapse div and open it
        const accordionCollapse = link.closest(".accordion-collapse");
        if (accordionCollapse) {
            accordionCollapse.classList.add("show"); // Keep accordion open

            // Find the corresponding button and add 'active' class
            const accordionButton =
                accordionCollapse.previousElementSibling.querySelector(
                    ".accordion-button"
                );
            if (accordionButton) {
                accordionButton.classList.remove("collapsed"); // Remove collapsed class
            }
        }
    }
});
