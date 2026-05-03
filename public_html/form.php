<?php
// Настройки получателя
$to = "mailto:sennoymarket@piter-center.ru"; // ← Укажите здесь ваш email!
$subject = "Новая заявка на аренду";

// Проверяем, что форма отправлена методом POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Получаем и фильтруем данные
    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $space_type = trim($_POST["space_type"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // Простая валидация
    $errors = [];
    if ($name === "") $errors[] = "Введите имя.";
   // if ($phone === "") $errors[] = "Введите телефон.";
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Укажите корректный email.";
    if ($space_type === "") $errors[] = "Выберите тип площади.";

    if (count($errors) === 0) {
        // Формируем текст письма
        $body = "Имя: $name\n";
       // $body .= "Телефон: $phone\n";
        $body .= "Email: $email\n";
        $body .= "Тип площади: $space_type\n";
        $body .= "Комментарий: $message\n";

        // Отправляем письмо
       $headers = "From: info@infosennoy.ru\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            echo "<h2>Спасибо! Ваша заявка отправлена.</h2>";
        } else {
            echo "<h2>Ошибка! Не удалось отправить заявку.</h2>";
        }
    } else {
        // Выводим ошибки
        echo "<h2>Исправьте ошибки:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
   echo '</ul><a href="#" onclick="history.back();return false;">Назад</a>';

    }

} else {
    // Если зашли напрямую, а не через форму
    header("Location: /");
    exit;
}
?>
