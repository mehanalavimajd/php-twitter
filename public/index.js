/*
 * Add your JavaScript to this file to complete the assignment.
 */
var modal = document.getElementById("create-twit-modal");
var modalBackdrop = document.getElementById("modal-backdrop");

function displayNewTwitModal() {
  modal.classList.remove("hidden");
  modalBackdrop.classList.remove("hidden");
  modal.classList.add("unhidden");
  modal.classList.add("unhidden");
}

var createTwitButton = document.getElementById("create-twit-button");
createTwitButton.addEventListener('click', displayNewTwitModal);

function closeNewTwitModal() {
  modal.classList.remove("unhidden");
  modalBackdrop.classList.remove("unhidden");
  modal.classList.add("hidden");
  modalBackdrop.classList.add("hidden");
}

var closeButton = document.getElementsByClassName("modal-close-button")[0];
closeButton.addEventListener('click', closeNewTwitModal);
var cancelButton = document.getElementsByClassName("modal-cancel-button")[0];
cancelButton.addEventListener('click', closeNewTwitModal);
