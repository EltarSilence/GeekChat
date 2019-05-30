<?php
    function login ($username, $password){
        $mysqli = new mysqli("localhost", "root", "", "geekchat");
        if ($mysqli->connect_errno){
            die("Connessione al database fallita");
        }
        else{
             $query = 'SELECT *
                        FROM utenti 
                        WHERE username="'.$username.'" AND password="'.$password.'";';                        
                if ($result = $mysqli->query($query)){
                    if ($result->num_rows == 1){
                        $arr = $result->fetch_assoc();
                        $_SESSION['username'] = $arr['username'];
                        $_SESSION['id'] = $arr['id'];
                        $_SESSION['isAdmin'] = $arr['isAdmin'];
                        header("Location:chat");
                    }
                    else
                        die;
                }else{
                    echo 'Utente non trovato';
                
            }  
        }
    }
    

    function registrazione($username, $password){
    $mysqli = new mysqli("localhost", "root", "", "geekchat");
    if ($mysqli->connect_errno){
        die("Connessione al database fallita");
    }
    else{
        if (isset($_POST['submit'])){
            $queryCheck = 'SELECT username
                      FROM utenti 
                      WHERE username="'.$username.'";';
            $result = $mysqli->query($queryCheck);
            var_dump($queryCheck);
            if ($result->num_rows!=0){
                header("location:registrazione?err=1");
            }
            else{
                $query = 'INSERT INTO utenti (username, password, bio, isAdmin)
                    VALUES ("'.$_POST['username'].'", "'.$password.'", "", 0);';
                if ($result = $mysqli->query($query)){
                    $queryPrendoDati = 'SELECT *
                      FROM utenti 
                      WHERE username="'.$username.'";';
                    $result = $mysqli->query($queryPrendoDati);
                    if ($result->num_rows==1){
                        $arr = $result->fetch_assoc();
                        $_SESSION['id'] = $arr['id'];
                        $_SESSION['username'] = $arr['username'];
                        $_SESSION['isAdmin'] = $arr['isAdmin'];
                        header("location: chat");
                    }   
                }
                }
            }
        }
}
?>

