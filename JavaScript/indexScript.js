     //cytaty
        const cytaty = [
            "„Festiwal to przestrzeń spotkań, emocji i pasji — nasza strona łączy ludzi z ich doświadczeniami.”",
            "„Nie budujemy tylko strony - tworzymy przestrzeń dla wspomnień, inspiracji i nowych doświadczeń.”",
            "„Festiwale to święta wyobraźni — pozwalają nam oderwać się od codzienności i poczuć wspólnotę.”",
            "„Między sceną a tłumem rodzą się wspomnienia, które zostają z nami na zawsze.”",
            "„Każdy festiwal to nowa opowieść — z dźwiękiem, obrazem i emocją w roli głównej.”",
            "„Nie ma znaczenia, gdzie jesteś — liczy się energia ludzi, którzy są obok ciebie.”",
            "„Festiwal to więcej niż wydarzenie. To stan ducha.”",
            "„W muzyce, filmie, sztuce – festiwale łączą świat, który chce się dzielić pasją.”",
            "„To właśnie na festiwalu odkrywasz, że jesteś częścią czegoś większego.”"
        ];

        let obecnyCytat = 0;
        const text = document.getElementById("quote-text");

        function pokazCytaty(index) {
            text.style.opacity = 0;
            setTimeout(() => {
                text.textContent = cytaty[index];
                text.style.opacity = 1;
            }, 300);
        }

        function nastepnyCytat() {
            obecnyCytat = (obecnyCytat + 1) % cytaty.length;
            pokazCytaty(obecnyCytat);
        }

        function poprzedniCytat() {
            obecnyCytat = (obecnyCytat - 1 + cytaty.length) % cytaty.length;
            pokazCytaty(obecnyCytat);
        }

        //galeria
        let currentGalleryIndex = 0;
        const galleryItems = document.querySelectorAll('.gallery-item');
        const itemsPerPage = 3;

        function pokazGalerie(startIndex) {
            galleryItems.forEach((item, index) => {
                if (index >= startIndex && index < startIndex + itemsPerPage) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function pokanNastepneGaleria() {
            currentGalleryIndex = (currentGalleryIndex + itemsPerPage) % galleryItems.length;
            pokazGalerie(currentGalleryIndex);
        }

        function pokazPoprzednieGaleria() {
            currentGalleryIndex = (currentGalleryIndex - itemsPerPage + galleryItems.length) % galleryItems.length;
            pokazGalerie(currentGalleryIndex);
        }

        window.onload = function() {
            pokazGalerie(0);

    
    const przyciskWiecej = document.querySelector('.accommodation-more a');
    const ukryteHotele = document.querySelectorAll('.accommodation-card[style*="display: none"], .accommodation-card[data-toggle="true"]');
    let pokazane = false;

    przyciskWiecej.addEventListener('click', function (e) {
        e.preventDefault();

        if (!pokazane) {
            let licznik = 0;
            ukryteHotele.forEach(hotel => {
                if (licznik < 3) {
                    hotel.style.display = 'block';
                    hotel.setAttribute('data-toggle', 'true');
                    licznik++;
                }
            });
            pokazane = true;
            przyciskWiecej.textContent = 'Pokaż mniej';
        } else {
            ukryteHotele.forEach(hotel => {
                if (hotel.getAttribute('data-toggle') === 'true') {
                    hotel.style.display = 'none';
                    hotel.removeAttribute('data-toggle');
                }
            });
            pokazane = false;
            przyciskWiecej.textContent = 'Zobacz więcej noclegów';
        }
    })
}