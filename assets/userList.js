let icons = document.querySelectorAll('.img-icon');
let lists = document.querySelectorAll('.site-users');
let activeSite = [];
lists.forEach(()=>activeSite.push(false));

let refIcons = document.querySelectorAll('.ref-icon');
let refLists = document.querySelectorAll('.referred-box');
let activeRef = [];
refLists.forEach(()=>activeRef.push(false));

let plusIcon = document.getElementById('plusIcon').getAttribute('value');
let minusIcon = document.getElementById('minusIcon').getAttribute('value');


function setActive(i) {
    for(let j =0; j<activeSite.length; j++) {
        (i===j)?activeSite[j]=!activeSite[j]:activeSite[j]=false;
    }

    for(let j =0; j<activeRef.length; j++) {
       activeRef[j]=false;
    }

    displayLists();
    displayRef();
}

function displayLists() {
    for(let i=0; i<activeSite.length; i++) {
        if(activeSite[i]) {
            lists[i].classList.remove('d-none');
            icons[i].setAttribute('src', minusIcon);
        } else {
            lists[i].classList.add('d-none');
            icons[i].setAttribute('src', plusIcon);
        }
    }
}

function setRefActive(i) {
    for(let j =0; j<activeRef.length; j++) {
        (i===j)?activeRef[j]=!activeRef[j]:activeRef[j]=false;
    }

    displayRef();
}

function displayRef() {
    for(let i=0; i<activeRef.length; i++) {
        if(activeRef[i]) {
            refLists[i].classList.remove('d-none');
            refIcons[i].setAttribute('src', minusIcon);
        } else {
            refLists[i].classList.add('d-none');
            refIcons[i].setAttribute('src', plusIcon);
        }
    }
}

for(let i=0; i<icons.length; i++) {
    icons[i].addEventListener('click', setActive.bind(null, i));
}

for(let i=0; i<refIcons.length; i++) {
    refIcons[i].addEventListener('click', setRefActive.bind(null, i));
}
