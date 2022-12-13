function showPassword(id) {
    var pass = document.getElementById(id);
    var img = document.getElementById("oeil-"+id);
    if (pass.type === "password") {
      pass.type = "text";
      img.src="../sources/icons/visibility_off.svg";
    } else {
      pass.type = "password";
      img.src="../sources/icons/visibility_on.svg";
    }
  }


  function notification(couleurBG){

    
    // On récupère l'élément notification
    var notif = document.getElementById("notif");
    console.log(notif);
    
    // On affiche la notification
    notif.style.backgroundColor="\#"+couleurBG.substring(1);
    notif.className = "show";
    
    // On supprime la notification après 3 secondes
    setTimeout(function(){ 
      notif.className = notif.className.replace("show", ""); 
      document.getElementById("injection").remove();
  }, 3000);
  
    } 