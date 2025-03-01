function validateMarathiFields() {
    let fields = document.querySelectorAll(".marathiField");

    fields.forEach((field) => {
        let errorMsg = field.nextElementSibling; // Assuming the error message is right after input

        field.addEventListener("input", function () {
            let marathiPattern = /^[\u0900-\u097F\s]+$/; // Allow spaces along with Marathi characters
            let cleanedValue = field.value.replace(/[^\u0900-\u097F\s]/g, ""); // Remove invalid chars

            if (field.value !== cleanedValue) {
                if (errorMsg) errorMsg.style.display = "block"; // Show error
            } else {
                if (errorMsg) errorMsg.style.display = "none"; // Hide error
            }

            field.value = cleanedValue; // Update the field with the cleaned value
        });
    });
}

// Call function to apply validation on all fields
document.addEventListener("DOMContentLoaded", validateMarathiFields);
