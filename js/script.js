// ----------------------------- OTP Verification input managing ----------------------------------
const reg_otp_form = document.getElementById("reg-otp-form");
const inputs = reg_otp_form.querySelectorAll("input[type='number']");
const button = reg_otp_form.querySelector("input[type='submit']");

// console.log(inputs, button);
// iterate over all inputs
inputs.forEach((input, index1) => {
  input.addEventListener("keyup", (e) => {
    // This code gets the current input element and stores it in the currentInput variable
    // This code gets the next sibling element of the current input element and stores it in the nextInput variable
    // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
    const currentInput = input,
      nextInput = input.nextElementSibling,
      prevInput = input.previousElementSibling;

    // if the value has more than one character then clear it
    if (currentInput.value.length > 1) {
      currentInput.value = "";
      return;
    }
    // if the next input is disabled and the current value is not empty
    //  enable the next input and focus on it
    if (
      nextInput &&
      nextInput.hasAttribute("disabled") &&
      currentInput.value !== ""
    ) {
      nextInput.removeAttribute("disabled");
      nextInput.focus();
    }

    // if the backspace key is pressed
    if (e.key === "Backspace") {
      // iterate over all inputs again
      inputs.forEach((input, index2) => {
        // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
        // and the previous element exists, set the disabled attribute on the input and focus on the previous element
        if (index1 <= index2 && prevInput) {
          input.setAttribute("disabled", true);
          input.value = "";
          prevInput.focus();
        }
      });
    }
    //if the sixeth input( which index number is 5) is not empty and has not disable attribute then
    //add active class if not then remove the active class.
    if (!inputs[5].disabled && inputs[5].value !== "") {
      button.removeAttribute("disabled");
      return;
    }
    button.setAttribute("disabled", "");
  });
});

// -----------------------------OTP Verification input managing----------------------------------
