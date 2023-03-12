let questionActuelle = 0;
let numQuestion=ListeQuestionHTML.length;
console.log(numQuestion);
function suivant() {
    //On recupere la variable global ListeQuestionHTML  
    if (questionActuelle == numQuestion) {
        alert("Fin du questionnaire");
        return;
    }
    document.getElementById('jsp').innerHTML=ListeQuestionHTML[questionActuelle];
    //On regarde si c'est une question QCM ou un question Libre
    if (ListeQuestionHTML[questionActuelle].includes("QCM")) {
        //Si y a des checkbox alors c'est une question QCM avec des checkbox
        if (ListeQuestionHTML[questionActuelle].includes("checkbox")) {
            //On recupere le bouton de class next
            let next = document.getElementsByClassName("next")[0];
            //On lui ajoute un event listener
            next.addEventListener("click", function () {
                //On recupere les checkbox
                let checkbox = document.getElementsByClassName("checkbox");
                //On regarde si une checkbox est coché
                let coche = false;
                for (let i = 0; i < checkbox.length; i++) {
                    if (checkbox[i].checked) {
                        coche = true;
                    }
                }
                //Si une checkbox est coché on passe a la question suivante
                if (coche) {
                    suivant();
                }
                //Sinon on affiche un message d'erreur
                else {
                    alert("Veuillez cocher une réponse");
                }
            });
        }
        //Sinon c'est une question QCM avec des simple
        else {
            alert("QCM simple");
        }
    }
    else if (ListeQuestionHTML[questionActuelle].includes("Libre")) {
        alert("Libre");
    }
    questionActuelle++;
}

suivant();