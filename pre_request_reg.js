pm.sendRequest({
    url: 'http://127.0.0.1:8080/register',
    method: 'GET',
    header: {
        'Content-Type': 'text/html' // Указываем тип контента, чтобы корректно обработать ответ
    }
}, function (err, response) {
    if (err) {
        console.error('Ошибка при выполнении GET запроса:', err);
    } else {
        try {
            // Проверяем, что ответ получен успешно и его тело не пустое
            if (response && response.text) {
                var html = response.text();
                var match = html.match(/name="registration_form\[_token\]" value="([^"]+)"/);
                if (match && match[1]) {
                    // Извлекаем CSRF токен
                    var csrfToken = match[1];
                    // Устанавливаем его как глобальную переменную для использования в последующих запросах
                    pm.globals.set('csrfToken', csrfToken);
                    console.log('CSRF токен успешно получен:', csrfToken);
                } else {
                    console.error('CSRF токен не найден в ответе');
                }
            } else {
                console.error('Пустой или некорректный ответ на GET запрос');
            }
        } catch (error) {
            console.error('Ошибка при обработке HTML ответа:', error);
        }
    }
});
