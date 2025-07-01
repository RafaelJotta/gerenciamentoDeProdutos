// /js/animacoes.js

document.addEventListener('DOMContentLoaded', () => {
    // Animação de Fade-in para o corpo da página
    let opacity = 0;
    const body = document.body;
    body.style.opacity = 0;
    const fadeInInterval = setInterval(() => {
        if (opacity < 1) {
            opacity += 0.05;
            body.style.opacity = opacity;
        } else {
            clearInterval(fadeInInterval);
        }
    }, 20);

    // Animação de Slide-in para títulos
    const titles = document.querySelectorAll('h1, h2');
    titles.forEach((title, index) => {
        let posY = -20;
        let opacity = 0;
        const slideInInterval = setInterval(() => {
            if (posY < 0) {
                posY += 1;
                opacity += 0.05;
                title.style.transform = `translateY(${posY}px)`;
                title.style.opacity = opacity;
            } else {
                title.style.transform = 'translateY(0)';
                title.style.opacity = 1;
                clearInterval(slideInInterval);
            }
        }, 15 + index * 5);
    });

    // Animação para cards de produto
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        setTimeout(() => {
            let scale = 0.9;
            let opacity = 0;
            const cardInInterval = setInterval(() => {
                if (scale < 1) {
                    scale += 0.01;
                    opacity += 0.05;
                    card.style.transform = `scale(${scale})`;
                    card.style.opacity = opacity;
                } else {
                    card.style.transform = 'scale(1)';
                    card.style.opacity = 1;
                    clearInterval(cardInInterval);
                }
            }, 10);
        }, index * 100);
    });

    // Animação de botões no mouseover
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('mouseover', () => {
            btn.style.transform = 'scale(1.05)';
        });
        btn.addEventListener('mouseout', () => {
            btn.style.transform = 'scale(1)';
        });
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'scale(0.95)';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = 'scale(1.05)';
        });
    });

    // Filtro de pesquisa de produtos
    const searchInput = document.getElementById('search-product');
    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            const filter = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(filter)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

// 
function confirmarExclusao() {
    return confirm("Tem certeza que deseja excluir este produto?");
}