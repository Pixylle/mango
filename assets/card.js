console.log("Код card.js загружен!");

document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (event) {
        const button = event.target.closest('.add-to-cart-btn');
        if (!button) return;

        console.log("Клик по кнопке", button);

        const platId = button.getAttribute('data-id');
        console.log("ID блюда:", platId);

        const quantityInput = document.getElementById(`quantity-${platId}`);
        const quantity = quantityInput ? quantityInput.value : 1;

        fetch(`/panier/add/ajax/${platId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
       
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Удаление одного товара
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id');
            
            fetch(`/panier/remove/${itemId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Erreur:', error));
        });
    });

    // Очистка корзины
    const viderButton = document.querySelector('.с');
    if (viderButton) {
        viderButton.addEventListener('click', function () {
            fetch('/panier/clear', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Erreur:', error));
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Обработчик кликов на кнопки удаления товара
    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function () {
            const platId = this.getAttribute("data-id");

            fetch(`/panier/remove/${platId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector("meta[name='csrf-token']").content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest(".cart-item").remove(); // Удаляем товар из DOM
                    updateCartTotal(data.totalPrice); // Обновляем сумму корзины
                } else {
                    alert("Erreur lors de la suppression.");
                }
            })
            .catch(error => console.error("Ошибка:", error));
        });
    });

    // Функция обновления суммы корзины
    function updateCartTotal(newTotal) {
        const totalElement = document.querySelector(".cart-footer h4");
        if (totalElement) {
            totalElement.textContent = `Total: ${newTotal} €`;
        }
    }
});
