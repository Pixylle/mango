
// index.js
import React from 'react';
import ReactDOM from 'react-dom/client';
import PlatCat from './platscat'; // Импорт компонента PlatCat

const App = () => {
    return (
        <div>
            <PlatCat categoryId={1} /> {/* Передаем ID категории */}
        </div>
    );
};

const rootElement = document.getElementById('categories-root');
if (rootElement) {
    ReactDOM.createRoot(rootElement).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}