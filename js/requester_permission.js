document.getElementById("permbtn").addEventListener('click', getPermission);

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getPermission() {
    //generate random pin number
    var pin = getRandomInt(1000, 10000);    
    //store it on local website
    localStorage.setItem('pin', pin);
    //wait asynchronously 1 sec (show graphic)
    //show message with pin
    alert("You have been granted permission by the admin!\nYour permission code is: " 
    + localStorage.getItem('pin'));    
}