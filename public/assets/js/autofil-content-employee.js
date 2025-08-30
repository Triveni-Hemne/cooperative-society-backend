/* --Age calculator-- */
document.addEventListener("DOMContentLoaded", function () {
    const dobInput = document.getElementById("dob");
    const ageInput = document.getElementById("age");

    dobInput.addEventListener("change", function () {
        const dob = new Date(this.value);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age >= 0 ? age : "";
    });
});
