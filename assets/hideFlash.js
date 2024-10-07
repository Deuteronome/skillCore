let flahes = document.querySelectorAll('.alert-custom');

flahes.forEach(element => {
    setTimeout(()=>element.style.width="0", 4000)
})