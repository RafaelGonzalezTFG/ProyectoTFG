<?php

//Agrupamos todo en modelo
namespace modelo;

//Importamos las clases para poder conectar con la base de datos
use \PDO;
use \PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Creamos una clase Utils
class Utils
{
    //Función para conectarnos con la base de datos mediante un objeto PDO
    public static function conectar()
    {
        //Variable
        $con_PDO = null;
        //Intentar conectar a base de datos y devolver el objeto PDO
        try {
            //Cargar los datos del archivo global una vez.
            require_once("../global.php");
            //Meter los parametros al objeto PDO
            $con_PDO = new PDO("mysql:host=" . $DB_SERVER . ";dbname=" . $DB_SCHEMA, $DB_USER, $DB_PASSWD);
            //Devolver el objeto PDO
            return $con_PDO;
        }

        //Catch si falla el objeto PDO de la conexion 
        catch (PDOException $th) {
            //Mensaje de error
            print "¡Error al conectar!: " . $th->getMessage() . "<br/>";
            //Devolvemos conexion null
            return $conPDO;
            //Terminamos con la conexion
            die();
        }
    }

    //Función para limpiar los datos
    public static function limpiar_datos($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Funcion para enviar el correo de activacion
    public static function enviarCorreoActivacion($correo, $codigoActivacion) {
        require_once("../vendor/autoload.php");
        $config = require("../email_configuracion.php");

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $config['HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['SMTP_USER'];
            $mail->Password = $config['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['SMTP_PORT'];

            // Recipients
            $mail->setFrom($config['SMTP_EMAIL'], $config['SMTP_NAME']);
            $mail->addAddress($correo);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Activación de cuenta';
            $mail->Body = "Hola,<br><br>Para activar tu cuenta, utiliza el siguiente código de activación: " . $codigoActivacion . "<br><br>Haz clic <a href='http://localhost/TiendaQuesorpresa/controller/activar_codigo_controlador.php?correo=" . urlencode($correo) . "'>aquí</a> para activar tu cuenta.";

            $mail->CharSet = 'UTF-8';  // Ensure the charset is set to UTF-8
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            return false;
        }
    }
    //Funcion para enviar el correo de contactos
    public static function enviarContactos($contactos) {
        require_once("../vendor/autoload.php");
        $config = require("../email_configuracion.php");


        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $config['HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['SMTP_USER'];
            $mail->Password = $config['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['SMTP_PORT'];

            // Recipients
            $mail->setFrom($config['SMTP_EMAIL'], $config['SMTP_NAME']);
            $mail->addAddress("proyectofingradormgp@gmail.com");

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Mensaje del usuario: ' . $contactos["nombre"] . ' ' . $contactos["nombre"] . ' desde ' . $contactos["correo"] . '';
            $mail->Body = $contactos["motivo"];

            $mail->CharSet = 'UTF-8';  // Ensure the charset is set to UTF-8
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            return false;
        }
    }
    //Funcion en la que enviamos un correo informando de la compra
    public static function enviarFactura($correo, $totalFactura) {
        require_once("../vendor/autoload.php");
        $config = require("../email_configuracion.php");

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $config['HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['SMTP_USER'];
            $mail->Password = $config['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['SMTP_PORT'];

            // Recipients
            $mail->setFrom($config['SMTP_EMAIL'], $config['SMTP_NAME']);
            $mail->addAddress($correo);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Gracias por comprar en Quesorpresa';
            $mail->Body = "Este es el importe de su pago: " . $totalFactura . "€<br>Que disfrute de su quesos y utensilios";

            $mail->CharSet = 'UTF-8';  // Ensure the charset is set to UTF-8
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            return false;
        }
    }
}

//Función para generar el código de activación aleatorio
function generarCodigoActivacion()
{
  $codigoActivacion = mt_rand(100000, 999999); // Genera un código de 6 dígitos aleatorio
  return $codigoActivacion;
}

