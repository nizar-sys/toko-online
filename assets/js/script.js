AOS.init({
  once: true,
});

const navBox = document.querySelector(".navbar-box");
const navButton = document.querySelector(".navbar-toggle");
navButton.addEventListener("click", function () {
  this.classList.toggle("active");
  navBox.classList.toggle("active");
});