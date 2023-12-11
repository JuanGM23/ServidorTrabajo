<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validar los datos (puedes agregar más validaciones según tus necesidades)

    // Enviar correo electrónico
    $to = "jgavilanmendez@gmail.com";
    $subject = "CONTACT";
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Componer el cuerpo del mensaje
    $mailBody = "Nombre: Juan Jose $name\n\n" .
                "Correo electrónico: juanjose.gavilan@a.vedrunasevillasj.es $email\n\n" .
                "Mensaje: Buenas muchas gracias por haber contactado con nosotros.\n$message";

    // Enviar el correo electrónico
    mail($to, $subject, $mailBody, $headers);

    // Redirigir a la página de éxito
    header('Location: contact_success.php');
    exit();
} else {
    // Redireccionar si se intenta acceder directamente al script sin enviar datos
    header('Location: contact_form_view.php');
    exit();
}
?>
