function enlargeImg(e){
    const step = e.currentTarget.value
    const imgContainer = document.getElementById("enlargeImg")
    imgContainer.setAttribute("src", `../../img/5879b/step_${step}.png`)
}

const enlargeBtn = document.querySelectorAll("button.btn.btn-warning")
enlargeBtn.forEach((btn)=>{
    btn.addEventListener("click", enlargeImg)
})