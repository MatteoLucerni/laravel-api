console.log("Js Loaded");

const slugViewField = document.getElementById("slug-view");
const slugField = document.getElementById("slug");
const titleField = document.getElementById("title");

titleField.addEventListener("input", () => {
    slugField.value = slugViewField.value = titleField.value
        .trim()
        .toLowerCase()
        .split(" ")
        .join("-");
});
