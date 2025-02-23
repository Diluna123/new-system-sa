function getLocation(){
    const locText = document.getElementById("locText");

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition((position)=>{
            console.log(position);
            locText.value ="http://maps.google.com/maps?q="+position.coords.latitude+","+position.coords.longitude;
        });
    }
    else{
        locText.innerHTML = "Geolocation is not supported by this browser.";
    }

    



}