const form = document.querySelector(".login form"),
continueBtn = document.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{

    let xhr = new XMLHttpRequest(); //creating xhr object.
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status == 200){
                let data = xhr.response;
                if(data == "success"){
                    console.log(data);
                    location.href = "users.php";
                }else{
                    errorText.style.display = "block";
                    errorText.textContent = data;
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}