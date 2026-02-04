const navLink = document.querySelectorAll(".nav-link");

navLink.forEach((link) => {
  link.classList.remove("active");

  if (link.href === window.location.href) {
    link.classList.add("active");
  }
});

// pinjam buku
const btnPinjam = document.querySelectorAll('.btn-pinjam');

btnPinjam.forEach(btn => {
  btn.addEventListener('click', function() {
    const buku_id = this.getAttribute('data-id');
    document.getElementById('modal_buku_id').value = buku_id;
  })
})

