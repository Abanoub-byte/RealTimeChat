const searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
usersList = document.querySelector(".users .users-list");

searchBtn.onclick = ()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
}
searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if(searchTerm != ""){
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest(); 
    
    xhr.open("POST", "php/search.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
              
                usersList.innerHTML = data;
            } // <-- Closing bracket for xhr.status === 200
        } // <-- Closing bracket for xhr.readyState === XMLHttpRequest.DONE
    };
    
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
};


setInterval(()=>{
    //lets start ajax agin 

    let xhr = new XMLHttpRequest(); 
    xhr.open("GET","php/users.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(!searchBar.classList.contains("active")){
                    usersList.innerHTML = data;
                }
            }else{
                console.error("Request failed due to an error", xhr.status);
            }
        }
    };
    xhr.onerror = ()=>{
        console.error("Request failed due to a network error.");
    }

    xhr.send();
}, 500); //this means the function will run every 500ms 
