const Encore = require('@symfony/webpack-encore');

Encore
    // Указываем папку для собранных файлов
    .setOutputPath('public/build/')
    // Указываем публичный путь для доступа к этим файлам
    .setPublicPath('/build')
    // Добавляем основной файл приложения
    .addEntry('app', './assets/app.js')
    .addEntry('card', './assets/card.js')  // Добавляем card.js
    .addEntry('platscat', './assets/platscat.jsx')  
    // Включаем поддержку React
    .enableReactPreset()
    // Включаем поддержку Sass
    .enableSassLoader()
    // Копируем изображения
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })
    .enableSingleRuntimeChunk()
    // Очищаем папку output перед каждой сборкой
    .cleanupOutputBeforeBuild()
    // Включаем карты кода для разработки
    .enableSourceMaps(!Encore.isProduction())
    // Включаем версии файлов для production-сборок


// Экспортируем конфигурацию
module.exports = Encore.getWebpackConfig();

