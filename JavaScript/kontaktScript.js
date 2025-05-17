//aplikownaie do pracy
function otworzNowe(positionId) {
    const contents = document.getElementsByClassName('position-content');
    for (let i = 0; i < contents.length; i++) {
        contents[i].style.display = 'none';
    }
    
    const tabs = document.getElementsByClassName('position-tab');
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }
    
    document.getElementById(positionId).style.display = 'block';
    event.currentTarget.classList.add('active');
    
    document.getElementById('position').value = positionId;
}

document.getElementById('job-application').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Dziękujemy za aplikację! Skontaktujemy się z Tobą wkrótce.');
    this.reset();
});

//formularz Kontaktowy
document.addEventListener('DOMContentLoaded', function() {
    const formularzKontaktowy = document.querySelector('form[action="#"]');
    
    if (formularzKontaktowy) {
        formularzKontaktowy.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            if (name && email && message) {
                alert("Twoja wiadomosc została wysłana!")
                formularzKontaktowy.reset();
            } else {
                alert('Proszę wypełnić wszystkie wymagane pola!');
            }
        });
    }
});