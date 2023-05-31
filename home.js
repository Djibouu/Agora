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

document.addEventListener("DOMContentLoaded", function () {
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