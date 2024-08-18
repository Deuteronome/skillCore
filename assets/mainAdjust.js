let header = document.querySelector('header');
let main = document.querySelector('main');

function mainAdjust() {
    let headerHeight = header.offsetHeight;
    main.style.top = `${headerHeight}px`;
}

mainAdjust();

window.onresize = mainAdjust;