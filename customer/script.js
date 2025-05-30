const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});
// Get modal and the elements for opening and closing it
var modal = document.getElementById("termsModal");
var termsLink = document.getElementById("termsLink");
var closeBtn = document.getElementsByClassName("close")[0];
var closeModalBtn = document.getElementsByClassName("close-modal")[0]; // New close button inside modal

// When the user clicks the "Terms and Conditions" link, open the modal
termsLink.onclick = function(event) {
    event.preventDefault(); // Prevent the default link action
    modal.style.display = "block"; // Show the modal
}

// When the user clicks on the close button (X), close the modal
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks the close modal button, close the modal
closeModalBtn.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

