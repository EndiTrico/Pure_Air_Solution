const sign_in_btn = document.querySelector("#sign-in-btn");
const welcome_btn = document.querySelector("#welcome-btn");
const container = document.querySelector(".container");

welcome_btn.addEventListener("click", () => {
  container.classList.add("welcome-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("welcome-mode");
});