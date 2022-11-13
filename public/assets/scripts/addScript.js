const choekboxes = document.querySelectorAll(".styleTags");
const maxCheckedBoxes = 2;

for (let i = 0; i < choekboxes.length; i++)
    choekboxes[i].onclick = selectiveCheck;
function selectiveCheck(event) {
    let checkedChecks = document.querySelectorAll(".styleTags:checked");
    if (checkedChecks.length >= maxCheckedBoxes + 1)
        return false;
}
