const visibilityBtn1 = document.getElementById("password-eye1")
visibilityBtn1.addEventListener("click", toggleVisibility1)

function toggleVisibility1() {
    const passwordInput1 = document.getElementById("saisieMdp1")
    // FIXME : Changement d'icone qui ne fonctionne pas
    const icon1 = document.getElementById("password-eye-icon1")

    if (passwordInput1.type === "password") {
        passwordInput1.type = "text"
        icon1.inerT = "visibility_off"
    } else {
        passwordInput1.type = "password"
        icon1.inerT = "visibility_on"
    }
}

const visibilityBtn2 = document.getElementById("password-eye2")
visibilityBtn2.addEventListener("click", toggleVisibility2)
function toggleVisibility2() {
    const passwordInput2 = document.getElementById("saisieMdp2")
    // FIXME : Changement d'icone qui ne fonctionne pas
    const icon2 = document.getElementById("password-eye-icon2")
    if (passwordInput2.type === "password") {
        passwordInput2.type = "text"
        icon2.inerT = "visibility_off"
    } else {
        passwordInput2.type = "password"
        icon2.inerT = "visibility_on"
    }
}
