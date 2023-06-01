document.getElementById("userType").addEventListener("change", function() {
    var userType = this.value;
    var acheteurFields = ["nom", "prenom", "email", "password", "pseudo", "image", "adresse", "ville", "codePostal", "pays", "typePaiement", "numeroCarte", "nomCarte", "dateExpiration", "codeCarte"];
    var vendeurFields = ["pseudo", "password", "email", "nom", "prenom", "image"];

    // Hide all fields
    var allFields = document.querySelectorAll("input, label");
    allFields.forEach(function(field) {
      field.classList.add("hidden");
    });

    // Show the fields based on user type
    if (userType === "acheteur") {
      acheteurFields.forEach(function(field) {
        document.getElementById(field).classList.remove("hidden");
        document.querySelector('label[for="' + field + '"]').classList.remove("hidden");
      });
    } else if (userType === "vendeur") {
      vendeurFields.forEach(function(field) {
        document.getElementById(field).classList.remove("hidden");
        document.querySelector('label[for="' + field + '"]').classList.remove("hidden");
      });
    }

    // Show submit button when a user type is selected
    document.getElementById("submitBtn").classList.remove("hidden");
  });