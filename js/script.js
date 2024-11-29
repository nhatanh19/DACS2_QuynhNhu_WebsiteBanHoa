//------------------Menu-item--------------------
const toP=document.querySelector(".top")
window.addEventListener("scroll",function() {
    const x= this.pageYOffset;
    if(x>1) {
        toP.classList.add("active")
    } else {
        toP.classList.remove("active")
    }
})
//------------Menu-slibar-cartegegory------
const itemsliderbar=document.querySelectorAll(".cartegory-left-li")
itemsliderbar.forEach(function(menu,index) {
    menu.addEventListener("click",function() {
        menu.classList.toggle("block")
    })
})
//-------------PRODUCT------
const bigImg = document.querySelector(".product-content-left-big-img img")
const smalImg = document.querySelectorAll(".product-content-left-small-img img")
smalImg.forEach(function(imgItem,X){
    imgItem.addEventListener("click",function(){
        bigImg.src = imgItem.src
    })
})


const baoquan = document.querySelector(".baoquan")
const chitiet = document.querySelector(".chitiet")
if(baoquan){
    baoquan.addEventListener("click", function(){
        document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "none"
        document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "block"
    })
}
if(chitiet){
    chitiet.addEventListener("click", function(){
        document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "block"
        document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "none"
    })
}
const butTon = document.querySelector(".product-content-right-bottom-top")
if(butTon){
    butTon.addEventListener("click", function(){
        document.querySelector(".product-content-right-bottom-content-big").classList.toggle("activeB")
    })
}