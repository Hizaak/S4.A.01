let questionActuelle = 0;
let numQuestion=ListeQuestionHTML.length;
console.log(numQuestion);
console.log(questionActuelle);
function suivant() {
    if (questionActuelle == numQuestion) {
        //On redirige vers la page d'accueil dans 1 seconde
        setTimeout(function () {
            window.location.href = "accueil.php";
        }, 1000);
        return
    }
    document.getElementById('carteActuelle').innerHTML=ListeQuestionHTML[questionActuelle];
    //On regarde si c'est une question QCM ou un question Libre
    idQuestion=document.getElementsByClassName("carte")[0].getAttribute("id").replace("carte","").replace("sep","");;
    if (ListeQuestionHTML[questionActuelle].includes("QCM")) {
        //Si y a des checkbox alors c'est une question QCM avec des checkbox
        if (ListeQuestionHTML[questionActuelle].includes("checkbox")) {
            btnSuivant=document.getElementsByClassName("next")[0];
            NbRepMax=btnSuivant.getAttribute("data-maxreponse");
            let BoutonReponseQCM = document.getElementsByClassName("BoutonReponseQCM");
            for (let i = 0; i < BoutonReponseQCM.length; i++) {
                    BoutonReponseQCM[i].addEventListener("click", function () {
                        check_Nbreponses_Checkbox(BoutonReponseQCM);
                });
            }
            btnSuivant.addEventListener("click", function () {
                if(check_Nbreponses_Checkbox(BoutonReponseQCM)==true){
                    let reponse = [];
                    for (let i = 0; i < BoutonReponseQCM.length; i++) {
                        if (BoutonReponseQCM[i].checked) {
                            //On push le label de la checkbox en prenant le label étant le frere du input
                            reponse.push(BoutonReponseQCM[i].nextElementSibling.innerText);
                        }
                    }
                    sendReponse(idQuestion, reponse);
                    suivant();
                }
            }
            );
        }
        //Sinon c'est une question QCM avec des simple
        else {
            //On met un event listener sur les boutons input de class BoutonReponseQCM
            let BoutonReponseQCM = document.getElementsByClassName("BoutonReponseQCM");
            for (let i = 0; i < BoutonReponseQCM.length; i++) {
                BoutonReponseQCM[i].addEventListener("click", function () {
                    //On recupere la valeur de l'input et on le met dans un array réponse
                    sendReponse(idQuestion, [this.value])
                    suivant();
                });
        }
    }
    }
    else if (ListeQuestionHTML[questionActuelle].includes("Libre")) {
        //On fait un event listener sur le textarea inputReponseLibre pour qu'il active le bouton suivant si le texte fait moi de 10 caractères
        let inputReponseLibre = document.getElementsByClassName("inputReponseLibre")[0];
        btnSuivant=document.getElementsByClassName("next")[0];
        let maxCar=parseInt(btnSuivant.getAttribute("data-maxCar"));
        inputReponseLibre.addEventListener("keyup", function () {
            console.log(inputReponseLibre.value.length > maxCar);
            if (inputReponseLibre.value.length > maxCar || inputReponseLibre.value.length == 0) {
                btnSuivant.disabled=true;
            }
            else{
                btnSuivant.disabled=false;
            }
        });
        btnSuivant.addEventListener("click", function () {
            //On simule un event pour vérifier si le bouton doit être cliquable ou non
            inputReponseLibre.dispatchEvent(new Event('keyup'));
            if(btnSuivant.disabled==false){
                sendReponse(idQuestion, [inputReponseLibre.value]);
                suivant();
            }
        }
        );
    }
    questionActuelle++;
}


function check_Nbreponses_Checkbox(BoutonReponseQCM) {
    let NbRepCoche = 0;
    for (let i = 0; i < BoutonReponseQCM.length; i++) {
        if (BoutonReponseQCM[i].checked) {
            NbRepCoche++;
        }}
    if(NbRepCoche>NbRepMax || NbRepCoche==0){
        //On desactive le bouton suivant
        btnSuivant.disabled=true;
        return false;
    }

    else{
        //On active le bouton suivant
        btnSuivant.disabled=false;
        return true;
    }


}



function sendReponse(idQuestion, reponse) {
    // On va utiliser de l'ajax pour envoyer les donnéess
    $.ajax({
        url: 'addReponse.php',
        type: 'POST',
        data: {
            idQuestion: idQuestion,
            reponse: reponse
        },
        success: function (data) {
            // if (data == "ok") {
            //     console.log("ok");
            //     return true;
            // }
            console.log(data);
        }
    });    
}
    

suivant();