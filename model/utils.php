<?php

// Agrupamos todo en modelo
namespace modelo;

// Importamos las clases para poder conectar con la base de datos
use \PDO;
use \PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Creamos una clase Utils
class Utils
{
    // Función para conectarnos con la base de datos mediante un objeto PDO
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

    // Función para limpiar los datos
    public static function limpiar_datos($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    //EnviarCorreo
    public static function enviarCorreoActivacion($correo, $codigoActivacion)
    {
        require_once("../vendor/autoload.php");
        $config = require("../email_configuracion.php");

        // Debugging - Check if variables are set
        var_dump($config);

        $correo = new PHPMailer(true);

        try {
            // Server settings
            $correo->isSMTP();
            $correo->Host = $config['HOST'];
            $correo->SMTPAuth = true;
            $correo->Username = $config['SMTP_USER'];
            $correo->Password = $config['SMTP_PASS'];
            $correo->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $correo->Port = $config['SMTP_PORT'];

            // Recipients
            $correo->setFrom($config['SMTP_EMAIL'], $config['SMTP_NAME']);
            $correo->addAddress($correo);

            // Content
            $correo->isHTML(true);
            $correo->Subject = 'Activación de cuenta';
            $correo->Body = "Hola,<br><br>Para activar tu cuenta, utiliza el siguiente código de activación: " . $codigoActivacion . "<br><br>Haz clic <a href='http://localhost/temploWargames/controllers/User_Controller.php?action=activate&email=" . $correo . "&codigo=" . $codigoActivacion . "'>aquí</a> para activar tu cuenta.";

            $correo->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: {$correo->ErrorInfo}";
            return false;
        }
    }
}

// Función para generar el código de activación aleatorio
function generarCodigoActivacion()
{
  $codigoActivacion = mt_rand(100000, 999999); // Genera un código de 6 dígitos aleatorio
  return $codigoActivacion;
}

/*
//EnviarCorreo
    public static function enviarCorreoActivacion($email, $codigoActivacion)
    {
        require_once("../vendor/autoload.php");
        $config = require("../email_configuracion.php");

        // Debugging - Check if variables are set
        var_dump($config);

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
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Activación de cuenta';
            $mail->Body = "Hola,<br><br>Para activar tu cuenta, utiliza el siguiente código de activación: " . 1234 . "<br><br>Haz clic <a href='http://localhost/temploWargames/controllers/User_Controller.php?action=activate&email=" . $email . "&codigo=" . $codigoActivacion . "'>aquí</a> para activar tu cuenta.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            return false;
        }
    }
*/ 
