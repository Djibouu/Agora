const backToTopButton = document.getElementById('back-to-top');

backToTopButton.addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

window.addEventListener('scroll', () => {
  if (window.pageYOffset > 200) {
    backToTopButton.classList.add('show');
  } else {
    backToTopButton.classList.remove('show');
  }
});

document.addEventListener("DOMContentLoaded", function() {
  var dropdownMenu = document.getElementById("dropdownMenu");

  // Fonction exécutée lorsqu'on clique sur le bouton "Votre Compte"
  document.getElementById("yourAccountButton").addEventListener("click", function() {
      // Vérifier si l'utilisateur est connecté
      var identifiant = "<?php echo isset($_SESSION['identifiant']) ? $_SESSION['identifiant'] : ''; ?>";
      if (identifiant !== "") {
          // Ajouter les identifiants dans le menu déroulant
          dropdownMenu.innerHTML = "<li><a class='dropdown-item'>" + identifiant + "</a></li>";
      }
  });
});

document.addEventListener("DOMContentLoaded", function () {

  //POP UP__________________________________________________________________________________
  const popup = document.querySelector("#popup");
  const closeIcon = document.querySelector(".close");
  const body = document.querySelector("body"); // Récupérer l'élément body
  
  // Récupérer le bouton de connexion
  const connexionButton = document.querySelector("#hero button.btn-outline-secondary");
  const pasConnecte = document.querySelector(".connexion");

  // Récupérer le bouton "Créer un compte"
  const createAccountButton = document.querySelector("#createAccountButton");

  // Récupérer l'élément bouton pop-up connexion
  const connexionButtonPopUp = document.querySelector("#ConnexionButton");
  
  connexionButton.addEventListener("click", function () {
    popup.style.display = "block";
    body.classList.add("popup-opened");
  });
  pasConnecte.addEventListener("click", function () {
    popup.style.display = "block";
    body.classList.add("popup-opened");
  });
  connexionButtonPopUp.addEventListener("click", function () {
    popup.style.display = "none";
    body.classList.remove("popup-opened");
  });
  

  createAccountButton.addEventListener("click", function () {
    window.location.href = "SingUp.php";
  });
  closeIcon.addEventListener("click", function () {
    popup.style.display = "none";
    body.classList.remove("popup-opened");
  });

  window.addEventListener("scroll", function () {
    popup.style.top = "50%";

  
  });

  
  //POP UP__________________________________________________________________________________

  //VOTRE COMPTE____________________________________________________________________________



  //VOTRE COMPTE____________________________________________________________________________




    // Custom smooth scrolling function
  function smoothScrollTo(element, duration) {
    const start = window.scrollY;
    const target = element.getBoundingClientRect().top;
    const startTime = performance.now();

    function step(timestamp) {
        const elapsed = timestamp - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeInOutQuad = (t) => (t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2);

        window.scroll(0, start + target * easeInOutQuad(progress));

        if (progress < 1) {
            requestAnimationFrame(step);
        }
    }

    requestAnimationFrame(step);
  }

  // Typing effect
  const typedText = document.querySelector("#hero p");
  const text = typedText.textContent;
  let index = 0;
  function type() {
    if (index < text.length) {
      typedText.textContent = text.slice(0, index + 1);
      index++;
      setTimeout(type, 100);
    }
  }
  type();


    // Parallax effect
  const heroSection = document.querySelector("#hero");
  function parallax() {
    const scrollTop = window.pageYOffset;
    heroSection.style.backgroundPositionY = `${scrollTop * -0.5}px`;
  }
  window.addEventListener("scroll", parallax);


  window.addEventListener('scroll', function () {
    const header = document.querySelector('header');
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });

});
