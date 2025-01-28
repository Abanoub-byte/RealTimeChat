const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input");
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault();// adding an even listener to prevent the website from reloading "the default behavior of the form".
    //insted the form data later will be sent via ajax.

}
continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest(); //creating xml object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "users.php";
                    console.log(data);
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    // send the form data through to php.
    
    let formData = new FormData(form);
    xhr.send(formData);
}
