function toggleOpis(button) {
    const festiwalSection = button.closest('.festiwal-card');
    const krotkiOpis = festiwalSection.querySelector('.krotki-opis');
    const obrazek = festiwalSection.querySelector('img');

    festiwalSection.classList.toggle('expanded');

    if (festiwalSection.classList.contains('expanded')) {
        button.textContent = 'Zobacz mniej';
        button.style.backgroundColor = '#1e40af';
        button.style.color = 'white';
        obrazek.style.transform = 'scale(1.03)';
    } else {
        button.textContent = 'Zobacz więcej';
        button.style.backgroundColor = '';
        button.style.color = '';
        obrazek.style.transform = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Karuzela artystów
    const carousel = document.getElementById('carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const cardWidth = document.querySelector('.artysta-card').offsetWidth + 24; // 24 to gap

    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -cardWidth, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: cardWidth, behavior: 'smooth' });
    });
});


