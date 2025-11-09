var slides_container = document.getElementById("slide");
var previous_slide_index = 0;
var current_slide_index = 0;

var slide_interval = setInterval(slide_hero, 5000)

document.addEventListener("visibilitychange", () => {
    if (document.visibilityState == "visible") {
        slide_interval = setInterval(slide_hero, 5000)
    }
    else {
        clearInterval(slide_interval)
    }
})

function slide_hero() {
    slides_container.children[previous_slide_index].setAttribute( 'class', '');
    slides_container.children[current_slide_index].setAttribute( 'class', 'not-active');
    previous_slide_index = current_slide_index;
    current_slide_index += current_slide_index < 4 ? 1 : -4;
    slides_container.children[current_slide_index].setAttribute( 'class', 'active');
}