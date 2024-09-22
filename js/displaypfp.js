const image_input = document.querySelector("#file-upload");
    const pfpImage = document.querySelector("#pfp-pic-modal");
    // Additional event listener to handle clearing the image input
    image_input.addEventListener("click", function() {
        image_input.value = null; // Clear the file input
        pfpImage.src = "img/pfp.jpeg"; // Revert to default image
    });
    image_input.addEventListener("change", function() {
        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;
            pfpImage.src = uploaded_image;
        });

        if (this.files.length > 0) {
            reader.readAsDataURL(this.files[0]);
        } else {
            pfpImage.src = "img/pfp.jpeg"; // Revert to default image when no file is selected
        }
    });



// JavaScript code for calculating and displaying days since sign-up
const signUpDateElement = document.getElementById("signUpDate");
const signUpDateStr = signUpDateElement.getAttribute("data-value");

const signUpDate = new Date(signUpDateStr);
const currentDate = new Date();
const timeDifference = currentDate - signUpDate;
const daysSinceSignUp = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

const daysSinceSignUpElement = document.getElementById("daysSinceSignUp");
const daysSinceSignUpElementSplash= document.getElementById("daysSinceSignUpSplash");
daysSinceSignUpElement.textContent = `🔥${daysSinceSignUp} days🔥`;
daysSinceSignUpElementSplash.textContent = `🔥${daysSinceSignUp} days🔥`;
