function showPassword(id) {
    var pass = document.getElementById(id);
    var img = document.getElementById("oeil-"+id);
    if (pass.type === "password") {
      pass.type = "text";
      img.src="sources/icons/visibility_off.svg";
    } else {
      pass.type = "password";
      img.src="sources/icons/visibility_on.svg";
    }
  }