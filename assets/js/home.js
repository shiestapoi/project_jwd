document.addEventListener("scroll", function () {
  var homeSection = document.getElementById("home");
  var introduceSection = document.getElementById("introduce");
  var facilitiesSection = document.getElementById("facilities");
  var contactmeSection = document.getElementById("contactme");
  var homeLink = document.querySelector('a[href="#home"]');
  var introduceLink = document.querySelector('a[href="#introduce"]');
  var facilitiesLink = document.querySelector('a[href="#facilities"]');
  var contactmeLink = document.querySelector('a[href="#contactme"]');

  var homePosition = homeSection.getBoundingClientRect();
  var introducePosition = introduceSection.getBoundingClientRect();
  var facilitiesPosition = facilitiesSection.getBoundingClientRect();
  var contactmePosition = contactmeSection.getBoundingClientRect();

  if (homePosition.top < window.innerHeight && homePosition.bottom >= 0) {
    homeLink.classList.add("nav-active");
    introduceLink.classList.remove("nav-active");
    facilitiesLink.classList.remove("nav-active");
    contactmeLink.classList.remove("nav-active");
  } else if (
    introducePosition.top < window.innerHeight &&
    introducePosition.bottom >= 0
  ) {
    introduceLink.classList.add("nav-active");
    homeLink.classList.remove("nav-active");
    facilitiesLink.classList.remove("nav-active");
    contactmeLink.classList.remove("nav-active");
  } else if (
    facilitiesPosition.top < window.innerHeight &&
    facilitiesPosition.bottom >= 0
  ) {
    facilitiesLink.classList.add("nav-active");
    contactmeLink.classList.remove("nav-active");
    homeLink.classList.remove("nav-active");
    introduceLink.classList.remove("nav-active");
  } else if (
    contactmePosition.top < window.innerHeight &&
    contactmePosition.bottom >= 0
  ) {
    contactmeLink.classList.add("nav-active");
    homeLink.classList.remove("nav-active");
    introduceLink.classList.remove("nav-active");
    facilitiesLink.classList.remove("nav-active");
  } else {
    homeLink.classList.remove("nav-active");
    introduceLink.classList.remove("nav-active");
    facilitiesLink.classList.remove("nav-active");
  }
});
