<?php

class Metode
{

    public static function greska($poruka)
    {
        echo "<br>" . "<div style='color:rgba(255, 0, 0, 0.58);'>";
        trigger_error($poruka, E_USER_ERROR);
        echo "</div>";
    }

    public static function obavestenje($poruka)
    {
        echo "<br>" . "<div style='color:rgba(39, 40, 255, 0.58);'>";
        echo $poruka;
        echo "</div>";
    }

    public static function ocistiNiz(array $niz)
    {
        $noviNiz = [];

        foreach ($niz as $key => $value)
            array_push($noviNiz, array($key => trim($value) ) );

        return $noviNiz;
    }

    public static function __autoload($klasa)
    {
        include "include/class." . $klasa . ".php";
    }

    // Метода за испитивање уноса од нежељених карактера
    public static function mysqli_prep($value)
    {
        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysql_real_escape_string"); // i.e. PHP >= v4.3.0
        if ($new_enough_php) { // PHP v4.3.0 or higher
            // undo any magic quote effects so mysql_real_escape_string can do the work
            if ($magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = Baza::vratiInstancu()->vratiObjekatKonekcije()->escape_string($value);
        } else { // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if (!$magic_quotes_active) {
                $value = addslashes($value);
            }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }


    public static function preusmeri($url)
    {
        if(!empty($url) && $url!=null && strstr($url,'.'))
        header("Location: {$url}");
        exit;
    }

    public static function autorizuj($tip)
    {
        if(!isset($_SESSION['korisnik'][$tip]) )
        {
            self::preusmeri("login.php");
            echo "Да бисте приступили овом делу сајта, морате бити улоговани." ;
        }
    }

    public static function odjaviSe()
    {
        if( isset($_SESSION['korisnik']) )
            $_SESSION = [];
        else
        {
            session_start();
            $_SESSION = [];
        }

        if(isset($_COOKIE[session_name()]) )
            setcookie(session_name(),'',time()-3600,'/');

        session_destroy();

        Metode::preusmeri("login.php");

    }

} //klasa