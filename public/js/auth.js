document.addEventListener("DOMContentLoaded", function(){

    const password = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");
    const icon = toggle.querySelector("i");

    toggle.addEventListener("click", function(){

        if(password.type === "password"){
            password.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }else{
            password.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }

    });

});
