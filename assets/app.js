// app.js
import './styles/app.css'; // Импорт стилей
import React from 'react';
import { createRoot } from "react-dom/client"; // Используем createRoot из react-dom/client
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'; // Импорт React Router
import App from './categoriesApp'; // Импорт React-компонента с категориями
import PlatCat from './platscat'; // Импорт компонента для отображения блюд по категории

// Код для обработки кнопок корзины
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.add-to-cart-btn');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const platId = button.getAttribute('data-id');
            const quantityInput = document.getElementById(`quantity-${platId}`);
            const quantity = quantityInput ? quantityInput.value : 1;

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

// Основной компонент с маршрутизатором
const Root = () => {
    return (
        <Router>
            <Routes>
                {/* Главная страница */}
                <Route path="/" element={<App />} />

                {/* Страница с блюдами по категории */}
                <Route path="/plats/:id" element={<PlatCat />} />
            </Routes>
        </Router>
    );
};

// Убедитесь, что элемент с id="root" существует
const rootElement = document.getElementById('root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<Root />);
} else {
    console.error("Element with id 'root' not found");
}
