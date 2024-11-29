//------------------SLIDER--------------
const imgItem=document.querySelectorAll(".aspect-radio-169 img")
const imgItemContainer=document.querySelector(".aspect-radio-169")
const dotItem=document.querySelectorAll(".dot")
let index=0;
let imgLeng=imgItem.length
dotItem.forEach(function(image,index) {
  image.style.left=index*100+"%"
  dotItem[index].addEventListener("click",function() {
    sliderRun(index)
  })
})
function slider() {
  index++;
  if(index>= imgLeng) {index=0}
  sliderRun(index)
}
function sliderRun(index) {
  imgItemContainer.style.left="-"+index*100+"%"
  const dotActive=document.querySelector(".active")
  dotActive.classList.remove("active")
  dotItem[index].classList.add("active");
}
setInterval(slider,5000)
