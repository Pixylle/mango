import { Application } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

// Инициализация Stimulus
const app = Application.start();

// Загружаем контроллеры из папки controllers
const context = require.context('./controllers', true, /\.js$/);
app.load(definitionsFromContext(context));
