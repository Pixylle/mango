import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

import React from 'react';
import ReactDOM from 'react-dom';
import CategoryPage from './react/CategoryPage';

const rootElement = document.getElementById('categorie-root');
if (rootElement) {
    const categoryId = rootElement.dataset.categoryId; // Получаем ID категории
    ReactDOM.render(<CategoryPage categoryId={categoryId} />, rootElement);
}
