document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const platId = this.getAttribute('data-id');
            const quantityInput = document.getElementById(`quantity-${platId}`);
            const quantity = quantityInput ? quantityInput.value : 1;

            // Отправляем данные через fetch
            fetch(`/panier/add/ajax/${platId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content // Убедись, что у тебя есть этот meta-тег
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Ajouté au panier ! Total articles : ${data.totalItems}`);
                } else {
                    alert('Erreur lors de l\'ajout au panier.');
                }
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
            });
        });
    });
});