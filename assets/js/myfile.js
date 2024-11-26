let alert_message = document.querySelectorAll("#alert_message");
console.log(alert_message);

for (let i = 0; i < alert_message.length; i++){
    setTimeout(function(){
        alert_message[i].style.display = "none";
    },2000);
    
}