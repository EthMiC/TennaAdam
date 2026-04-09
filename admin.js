function drop_down() {
    let menu_bar = document.getElementById("options");
    if (menu_bar.classList.contains("visible")) {
        menu_bar.classList.remove("visible");
    }
    else {
        menu_bar.classList.add("visible");
    }
}