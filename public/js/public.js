// ===== NAVBAR SCROLL =====
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
});

// ===== SCROLL REVEAL =====
const reveals = document.querySelectorAll('.reveal, .feature-item, .bento-item');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, i * 80);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// ===== HAMBURGER MOBILE =====
const hamburger = document.getElementById('hamburger');
const navLinks  = document.querySelector('.nav-links');
let menuOpen    = false;

hamburger.addEventListener('click', () => {
    menuOpen = !menuOpen;
    if (menuOpen) {
        navLinks.style.cssText = `
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            background: rgba(13,31,45,0.97);
            padding: 24px;
            gap: 20px;
            z-index: 999;
        `;
    } else {
        navLinks.style.display = 'none';
    }
});

// tutup menu saat klik link
navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menuOpen = false;
        navLinks.style.display = 'none';
    });
});
