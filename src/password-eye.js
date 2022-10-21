function showPassword(id) {
    var pass = document.getElementById(id);
    var img = document.getElementById(id+"EYE");
    if (pass.type === "password") {
      pass.type = "text";
      img.src="/sources/icon/visibility_on.svg";
    } else {
      pass.type = "password";
      img.src="/sources/icon/visibility_off.svg";
    }
  }