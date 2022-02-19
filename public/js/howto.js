/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/howto.js ***!
  \*******************************/
function enlargeImg(e) {
  var step = e.currentTarget.value;
  var imgContainer = document.getElementById("enlargeImg");
  imgContainer.setAttribute("src", "/img/step_".concat(step, ".png"));
}

var enlargeBtn = document.querySelectorAll("button.btn.btn-warning");
enlargeBtn.forEach(function (btn) {
  btn.addEventListener("click", enlargeImg);
});
/******/ })()
;