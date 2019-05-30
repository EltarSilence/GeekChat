function CheckSignIn(f){
    var username = f.username.value;
    var password = f.pw.value;
    var checkPw = f.checkPw.value;
    if (username == "" || password == "" || checkPw == ""){
        document.getElementById("error").innerHTML = "Compilare tutti i campi!<br>";
        return false;
    }else{
        if (password != checkPw){
            document.getElementById("error").innerHTML = "Le due password non coincidono!<br>";
            return false;
        }
        else
            return true;
    }
}