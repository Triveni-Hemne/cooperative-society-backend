
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("employee");
    const nameInput = document.getElementById("userName");



    if (typeof data !== "undefined" && Array.isArray(data)) {
        const employeeMap = {};
        // Build a map for fast lookup
        data.forEach((employee) => {
            employeeMap[employee.employee_id] = employee;
        });

        select.addEventListener("change", function () {
            const selectedId = parseInt(this.value);

            const employee = employeeMap[selectedId];

            if (employee) {
                nameInput.value = employee.name || ""; // Use optional chaining
            } else {
                nameInput.value = "";
            }
        });
    }
});
