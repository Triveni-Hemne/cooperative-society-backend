document.addEventListener("DOMContentLoaded", function () {
    const memberSelect = document.getElementById("memberId");
    const nameInput = document.getElementById("Name");
    const emailInput = document.getElementById("email");
    const mob0Input = document.getElementById("mob0");
    const designationSelect = document.getElementById("designationId");

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
                emailInput.value = member.email || "";
                mob0Input.value = member.contact.mobile_no || "";

                if (designationSelect) {
                    for (let option of designationSelect.options) {
                        option.selected = option.value == member.designation_id;
                    }
                }
            } else {
                nameInput.value = "";
                emailInput.value = "";
                mob0Input.value = "";

                if (designationSelect) {
                    designationSelect.selectedIndex = 0; // Reset to first option
                }
            }
        });
    }
});
