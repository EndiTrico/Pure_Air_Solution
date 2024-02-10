const sign_in_btn = document.querySelector("#sign-in-btn");
const welcome_btn = document.querySelector("#welcome-btn");
const container = document.querySelector(".container");
var form = document.getElementById("signin-form");

welcome_btn.addEventListener("click", () => {
  container.classList.add("welcome-mode");
  form.classList.remove("hidden");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("welcome-mode");
  form.style.display = "block";
  form.classList.toggle("hidden");
});