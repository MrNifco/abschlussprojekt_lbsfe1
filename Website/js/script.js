document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Formular wurde erfolgreich gesendet!');
            form.reset();
        });
    }

    const header = document.querySelector('header');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
        if (lastScrollY < window.scrollY) {
            header.classList.add('hidden-header');
        } else {
            header.classList.remove('hidden-header');
        }
        lastScrollY = window.scrollY;
    });

    // Smooth scroll to contact section
    const contactLinks = document.querySelectorAll('a[href="#contact"]');
    const contactSection = document.getElementById('contact');

    contactLinks.forEach(contactLink => {
        contactLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (window.location.pathname === '/') {
                contactSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                window.location.href = '/#contact';
            }
        });
    });

    // Keep dropdown menu open when hovering over it or the menu button
    const menuBtn = document.querySelector('.menu-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    menuBtn.addEventListener('mouseenter', () => {
        dropdownMenu.style.display = 'block';
    });

    menuBtn.addEventListener('mouseleave', () => {
        setTimeout(() => {
            if (!dropdownMenu.matches(':hover')) {
                dropdownMenu.style.display = 'none';
            }
        }, 300);
    });

    dropdownMenu.addEventListener('mouseleave', () => {
        dropdownMenu.style.display = 'none';
    });

    dropdownMenu.addEventListener('mouseenter', () => {
        dropdownMenu.style.display = 'block';
    });
});
