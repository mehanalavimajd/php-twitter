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

function createTwit() {
  var twitText = document.getElementById("twit-text-input").value;
  var author = document.getElementById("twit-attribution-input").value;

  if(twitText == "" || author == "") {
    alert("Please enter something into the 'twit text' or 'author' box");
    return;
  }

  /*<article class="twit">
    <div class="twit-icon">
      <i class="fa fa-bullhorn"></i>
    </div>
    <div class="twit-content">
      <p class="twit-text">
        <--! Put the twit text entered by the user here. -->
      </p>
      <p class="twit-author">
        <a href="#"><--! Put the twit author entered by the user here. --></a>
      </p>
    </div>
  </article>*/
  var accessDOM = document.getElementsByClassName("twit-container")[0];

  var twitArticle = document.createElement('article');
  twitArticle.classList.add("twit");

  var twitIconDiv = document.createElement('div');
  twitIconDiv.classList.add("twit-icon");
  twitArticle.appendChild(twitIconDiv);

  var bullhornIcon = document.createElement('i');
  bullhornIcon.classList.add("fas");
  bullhornIcon.classList.add("fa-bullhorn");
  twitIconDiv.appendChild(bullhornIcon);

  var twitContentDiv = document.createElement('div');
  twitContentDiv.classList.add("twit-content");
  twitArticle.appendChild(twitContentDiv);

  var twitTextPar = document.createElement('p');
  twitTextPar.classList.add("twit-text");
  twitTextPar.textContent = twitText;
  twitContentDiv.appendChild(twitTextPar);

  var twitAuthorPar = document.createElement('p');
  twitAuthorPar.classList.add("twit-author");
  twitContentDiv.appendChild(twitAuthorPar);

  var authorHyperlink = document.createElement('a');
  authorHyperlink.href = "#";
  authorHyperlink.textContent = author;
  twitAuthorPar.appendChild(authorHyperlink);

  accessDOM.appendChild(twitArticle);

  closeNewTwitModal();

}

var acceptButton = document.getElementsByClassName("modal-accept-button")[0];
acceptButton.addEventListener('click', createTwit);



function search() {
    var allTwits = document.getElementsByClassName("twit");
    console.log("Num of twits", allTwits.length);
    var userInput = document.getElementById("navbar-search-input").value.toLowerCase();

    for(var i = 0; i < allTwits.length; i++) {
      var currTwit = allTwits[i].textContent.toLowerCase();

      if(!currTwit.includes(userInput)) {
        allTwits[i].remove();
      }
    }
}

var searchButton = document.getElementById("navbar-search-button");
searchButton.addEventListener('click', search);
var instaSearch = document.getElementById("navbar-search-input");
instaSearch.addEventListener('keyup', search);
