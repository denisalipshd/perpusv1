const navLink = document.querySelectorAll(".nav-link");

navLink.forEach((link) => {
  link.classList.remove("active");

  if (link.href === window.location.href) {
    link.classList.add("active");
  }
});


