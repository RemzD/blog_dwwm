var myInput1 = document.getElementById("password1");
var myInput2 = document.getElementById("password2");

var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var specialCharacter = document.getElementById("specialCharacter");

var passIdent = document.getElementById("passIdent");

//lorsque l'utilisateur clique sur le champ du mot de passe, affiche la boite de message
myInput1.onfocus = function() {
    document.getElementById("requiredCharacters").style.display = "block";
}

// lorsque l'utilisateur clique en dehors du champ du mot de passe, masque la boite de message
myInput1.onblur = function() {
    document.getElementById("requiredCharacters").style.display = "none";
}

myInput1.onkeyup = function() {
    keyValidation(letter, /[a-z]/);
    keyValidation(capital, /[A-Z]/);
    keyValidation(number, /[0-9]/);
    keyValidation(specialCharacter, /[@$!%*?&]/);
    keyValidation(length, /^\S{8,72}$/);
}

myInput2.onkeyup = function() {
    if (myInput1.value != myInput2.value) {
        passIdent.style.visibility = "visible";

    } else {
        passIdent.style.visibility = "hidden";
    }
}

// lorsque l'utilisateur commence à taper quelque chose dans le champ de mot de passe
function keyValidation(domElement, matching) {
    if (myInput1.value.match(matching)) {
        domElement.classList.remove("invalid");
        domElement.classList.add("valid");

    } else {
        domElement.classList.remove("valid");
        domElement.classList.add("invalid");
    }
}