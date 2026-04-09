var slides_container = document.getElementById("slide");
var previous_slide_index = 0;
var current_slide_index = 0;

slide_interval = setInterval(slide_hero, 3000);

document.addEventListener("visibilitychange", () => {
    if (document.visibilityState == "visible" && slide_interval == null) {
        slide_interval = setInterval(slide_hero, 3000);
    }
    else {
        clearInterval(slide_interval);
        slide_interval = null;
    }
})

function slide_hero() {
    slides_container.children[previous_slide_index].setAttribute( 'class', '');
    slides_container.children[current_slide_index].setAttribute( 'class', 'not-active');
    previous_slide_index = current_slide_index;
    current_slide_index += current_slide_index < slides_container.childElementCount - 1 ? 1 : -(slides_container.childElementCount - 1);
    slides_container.children[current_slide_index].setAttribute( 'class', 'active');
}