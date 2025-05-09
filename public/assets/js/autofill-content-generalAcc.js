document.addEventListener("DOMContentLoaded", function () {
    const memberSelect = document.getElementById("memberId");
    const nameInput = document.getElementById("Name");

    if (typeof memberData !== "undefined") {
        const memberMap = {};
        memberData.forEach((member) => {
            memberMap[member.id] = member;
        });
        memberSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const member = memberMap[selectedId];

            if (member) {
                nameInput.value = member.name || "";
            } else {
                // Show all accounts again if no member is selected
                nameInput.value = "";
            }
        });
    }
});
