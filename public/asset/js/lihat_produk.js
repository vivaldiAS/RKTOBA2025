let lastActiveElement = null;
let activeIndex = 0;
function checkActivateImage(){
    let elements = document.getElementsByClassName("list-image");
    let bigPreview = document.getElementById("big-preview");
    for(let i=0; i<elements.length; i++){
        let img = elements[i].children[0];
        if(activeIndex ==i){
            elements[i].classList.add("active");
            lastActiveElement =elements[i];
        }
    }
}

checkActivateImage();

let elements = document.getElementsByClassName("list-image");

let lastIndex = 0;
for (let i = 0; i < elements.length; i++){
    elements[i].addEventListener("click", (event)=>{
       let bigPreview = document.getElementById("big-preview"); 
       bigPreview.src = elements[i].children[0].src; 
       lastActiveElement.classList.remove("active");
       lastActiveElement = elements[i];
       if(i > 1 && activeIndex < i){
        const wrap = document.getElementById("wrap-preview-item");
        wrap.scrollLeft += 75;
       }else {
        const wrap = document.getElementById("wrap-preview-item");
        wrap.scrollLeft -= 75;
       }
       activeIndex = i;
       checkActivateImage();
    })
}

const dec = document.getElementById("quantity-decrement");
const inc = document.getElementById("quantity-increment");
const quantity = document.getElementById("quantity");

dec.addEventListener("click", () =>{
    if(quantity.value > 0){
        quantity.value = quantity.value -1;
    }
});

inc.addEventListener("click", () =>{
    if(Number(inc.dataset.max) > Number(quantity.value)) {
        quantity.value = Number(quantity.value) +1;
    }
});