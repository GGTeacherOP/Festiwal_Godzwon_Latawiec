 function toggleOpis(button) {
            const festiwalSection = button.closest('.festiwal');
            const pelnyOpis = festiwalSection.querySelector('.pelny-opis');
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