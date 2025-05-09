document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("employee");
    const nameInput = document.getElementById("userName");

    if (typeof data !== "undefined") {
        const employeeMap = {};
        data.forEach((employee) => {
            employeeMap[employee.id] = employee;
        });
        select.addEventListener("change", function () {
            const selectedId = this.value;
            const employee = employeeMap[selectedId];

            if (employee) {
                nameInput.value = employee.member.name || "";
            } else {
                nameInput.value = "";
            }
        });
    }
});
