import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.add-to-cart-btn');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const platId = button.getAttribute('data-id');
            const quantityInput = document.getElementById(`quantity-${platId}`);
            const quantity = quantityInput ? quantityInput.value : 1;

            console.log(`Отправляю запрос для блюда ID: ${platId}, количество: ${quantity}`);

            fetch(`/panier/add/ajax/${platId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ quantity }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Ответ от сервера:', data);

                    if (data.success) {
                        // Обновляем счётчик товаров в корзине
                        const cartCounter = document.getElementById('cart-counter');
                        if (cartCounter) {
                            cartCounter.textContent = data.totalItems;
                            cartCounter.style.display = data.totalItems > 0 ? 'block' : 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Ошибка при отправке запроса:', error);
                });
        });
    });
});
