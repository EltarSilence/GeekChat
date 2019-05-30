function CheckLogIn(f){
    var username = f.username.value;
    var password = f.password.value;
    if (username == "" || password == ""){
        document.getElementById("error").innerHTML = "Compilare tutti i campi!<br>";
        return false;
    }else
            return true;
}