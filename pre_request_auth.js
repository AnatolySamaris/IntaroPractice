// GET запрос для получения страницы с формой аутентификации и CSRF токеном
pm.sendRequest({
    url: 'http://127.0.0.1:8080/login', // Замените на реальный URL вашей страницы аутентификации
    method: 'GET',
}, function (err, response) {
    if (err) {
        console.error('Ошибка при выполнении GET запроса:', err);
    } else {
        // Парсим HTML ответ и извлекаем CSRF токен
        let html = response.text();
        
        // Используем регулярное выражение для поиска CSRF токена
        let matches = html.match(/<input[^>]*name="_csrf_token"[^>]*value="([^"]*)"[^>]*>/);
        let csrfToken = matches ? matches[1] : null;

        if (csrfToken) {
            // Сохраняем CSRF токен в переменную окружения или коллекции в Postman для использования в POST запросе
            pm.environment.set('csrfToken', csrfToken);
            console.log('CSRF токен успешно получен:', csrfToken);
        } else {
            console.error('CSRF токен не найден в HTML ответе.');
        }
    }
});
