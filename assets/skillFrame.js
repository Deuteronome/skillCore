let descTriggers = document.querySelectorAll('.icon-box');
let descriptors = document.querySelectorAll('.skill-body');

let isOpen =[];

function openClose(i) {
    //console.log(descTriggers[i].childNodes);
    if(isOpen[i]) {
        this.style.display = 'none';
        isOpen[i] = false;
        descTriggers[i].childNodes[0].setAttribute('href', './assets/images/icon/plusIcon.png');
    } else {
        this.style.display = 'block';
        isOpen[i] = true;
        descTriggers[i].childNodes[0].setAttribute('href', './assets/images/icon/minusIcon.png');
    }
}

for(let i=0; i < descTriggers.length; i++) {
    isOpen.push(false);
    descTriggers[i].addEventListener('click', openClose.bind(descriptors[i],i))
}

//console.log(descTriggers, descriptors);