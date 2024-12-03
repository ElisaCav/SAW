function isName(name){
    let namesPattern = new RegExp("^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$");
    return namesPattern.test(name);
}

function isEmail(email){
    //characters@characters.domain (characters followed by an @ sign, followed by more characters, and then a ".".
    //After the "." sign, you can only write 2 to 3 letters from a to z:</p>
    let emailPattern = new RegExp("^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$");
    return emailPattern.test(email);
}



function validateLoginForm() {

    var email = document.getElementById("email").value;
    var password = document.getElementById("pass").value;
    var emailerr = document.getElementById('email_error');
    var pwderr = document.getElementById('pwd_error');



    if (email === "") {
        emailerr.textContent = "Email obbligatoria.";
        return false;
    } 
    if(!isEmail(email)){
        emailerr.textContent = "Email non valida.";
        return false;
    }
    if(password === "") {
        pwderr.textContent = "Password obbligatoria.";
        return false;
    } else {
        emailerr.textContent = "";
        pwderr.textContent = "";
        return true;
    }
}

function validateRegistrationForm(){

    var isFormValid = true;

    // Get form values
    var firstname = document.getElementById("firstname").value.trim();
    var lastname = document.getElementById("lastname").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("pass").value;
    var confirm = document.getElementById("confirm").value;

    // Get error elements
    var firstnameError = document.getElementById("firstname_error");
    var lastnameError = document.getElementById("lastname_error");
    var emailError = document.getElementById("email_error");
    var passwordError = document.getElementById("pwd_error");
    var confirmPwdError = document.getElementById("confirm_error");

    // Reset previous errors
    firstnameError.textContent = "";
    lastnameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";
    confirmPwdError.textContent = "";

    // Validate name
    if (!isName(firstname) || firstname.length > 50) {
        firstnameError.textContent = "Inserire un nome valido (max 50 caratteri).";
        isFormValid = false;
    }

    // Validate surname
    if (!isName(lastname) || lastname.length > 50) {
        lastnameError.textContent = "Inserire un cognome valido (max 50 caratteri).";
        isFormValid = false;
    }

    // Validate email
    if (email === "") {
        emailError.textContent = "Email obbligatoria.";
        isFormValid = false;
    } else if (!isEmail(email)) {
        emailError.textContent = "Inserire un'email valida.";
        isFormValid = false;
    }

    // Validate password
    if (password === "") {
        passwordError.textContent = "Password obbligatoria.";
        isFormValid = false;
    }

    // Validate password confirmation
    if (confirm === "") {
        confirmPwdError.textContent = "Conferma Password obbligatoria.";
        isFormValid = false;
    } else if (password !== confirm) {
        confirmPwdError.textContent = "Le password non coincidono.";
        isFormValid = false;
    }

    return isFormValid;
}


function validateUpdateProfileForm(){ 
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var firstnameError = document.getElementById("firstname_error");
    var lastnameError = document.getElementById("lastname_error");
    var isFormValid = true;

    if(!isName(firstname) || firstname.length >50){
        console.log("nome: " + firstname + "valutazione: " + isName(firstname));
        document.getElementById("firstname_error").textContent="Inserire un nome valido";
        isFormValid=false;
    } else {
        firstnameError.innerHTML = ""; // Remove error message
    }

    if(!isName(lastname) || lastname.length >50){
        console.log("cognome: " + lastname + "valutazione: " + isName(lastname));
        document.getElementById("lastname_error").textContent="Inserire un cognome valido";
        isFormValid=false;
    } else {
        lastnameError.innerHTML = ""; // Remove error message
    }

    return isFormValid;

}

function cancelData(){
    // the button 'cancel' triggers page refresh
    location.reload();
}
