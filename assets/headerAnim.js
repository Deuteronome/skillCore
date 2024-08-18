let animBoxes = document.querySelectorAll('.back-anim');
let container = document.querySelector('#header-top');


function zoneAdjust() {
    let zoneHeight = container.offsetHeight;
    animBoxes.forEach((element)=> {element.style.height = `${zoneHeight-2}px`});
}

function moveBoxes() {
    animBoxes.forEach((element) => {
        let position = 0;
        switch(element.getAttribute('id')) {    
            case 'back-anim-mid':
               setInterval(()=> {
                    position += 1;
                    element.style.backgroundPositionY = `${position}px`;
                }, 50)
                break;
            case 'back-anim-light':
                setInterval(()=> {
                    position += 2;
                    element.style.backgroundPositionY = `${position}px`;
                }, 50)
                break;
            default:
                setInterval(()=> {
                    position -= 1;
                    element.style.backgroundPositionY = `${position}px`;
                }, 50)
                break
        }
    })
}

zoneAdjust();
moveBoxes();

window.onresize = zoneAdjust;