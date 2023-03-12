function arrayToTable(array) {
    var table = "<table><thead><tr><th>Identifiant</th><th>Nom</th><th>Prenom</th><th>Année</th></tr></thead><tbody>";
    array.forEach(function(row) {
      table += "<tr>";
      row.forEach(function(cell) {
        table += "<td>" + cell + "</td>";
      });
      table += "</tr>";
    });
    table += "</tbody></table>";
    return table;
  }

//Dès qu'on a un fichier dans l'input file, on lance la fonction
document.getElementById('btnZone').addEventListener('change', function() {
    var file = event.target.files[0];
    //On vérifie que c'est bien un .txt ou un .csv
    if (file.name.split(".")[1] != "txt" && file.name.split(".")[1] != "csv") {
        alert("Le fichier n'est pas au bon format");
        return;
    }

    csv=Array();
    var error=false;
    var reader = new FileReader();
    reader.readAsText(file);
    reader.onload = function() {
      var lines = reader.result.split("\n");
      lines.forEach(function(line) {
        etudiant = line.split(";");
        //On vérifie qu'il y a bien 4 champs
        if (etudiant.length == 4) {
            //On enlève les espaces et les /r dans une boucle
            for (var i = 0; i < etudiant.length; i++) {
              etudiant[i] = etudiant[i].replace(/ /g, "");
              etudiant[i] = etudiant[i].replace(/\r/g, "");
              //si il y a un champ vide, on alerte l'utilisateur
              if (etudiant[i] == "") {
                error=true;
              }
                    
            }

            //On ajoute l'étudiant au tableau
            csv.push(etudiant);
        }
      });
    section=document.createElement("section");
    if (error) {
      //Si il y a une erreur, on affiche un message d'erreur
        var erreur = document.createElement("p");
        erreur.textContent="Il y a des erreurs dans le fichier";
        erreur.style.color="red";
        section.appendChild(erreur);
    }
    
    //On affiche le tableau
    section.innerHTML += arrayToTable(csv);
    //On recupere tous les logins deja dans le tableau
    let ids = document.getElementsByClassName("login");
    //On fait un dictonnaire pour stocker les logins avec comme clé le login et comme valeur l'element <td class="login">login</td>
    let logins = {};
    for (var i = 0; i < ids.length; i++) {
        logins[ids[i].textContent] = ids[i];
    }
    //Pour chaque etudiant on vérifie qu'il n'est pas déjà dans le tableau, si il y est un affiche un mesage de confirmation pour savoir si on doit reecrire l'etudiant avec la nouvelle information
    csv.forEach(function(etudiant) {
        if (etudiant[0] in logins) {
            //On regarde si les informations sont différentes
            if (logins[etudiant[0]].parentElement.children[1].textContent != etudiant[0] || logins[etudiant[0]].parentElement.children[2].textContent != etudiant[1] || logins[etudiant[0]].parentElement.children[3].textContent != etudiant[2] || logins[etudiant[0]].parentElement.children[4].textContent != etudiant[3]) {
                var confirmation = confirm("L'étudiant " + etudiant[0] + " est déjà dans le tableau, voulez vous le remplacer ?\n\nAncienne information:\n" + logins[etudiant[0]].parentElement.children[1].textContent + " | " + logins[etudiant[0]].parentElement.children[2].textContent + " | " + logins[etudiant[0]].parentElement.children[3].textContent + " | " + logins[etudiant[0]].parentElement.children[4].textContent + "\n\nNouvelle information:\n" + etudiant[0] + " | " + etudiant[1] + " | " + etudiant[2] + " | " + etudiant[3]);
                if (confirmation) {
                    logins[etudiant[0]].parentElement.children[1].textContent = etudiant[0];
                    logins[etudiant[0]].parentElement.children[2].textContent = etudiant[1];
                    logins[etudiant[0]].parentElement.children[3].textContent = etudiant[2];
                    logins[etudiant[0]].parentElement.children[4].textContent = etudiant[3];
                }
            }
        } else {
            //Sinon on ajoute l'étudiant
            add_line(etudiant[0], etudiant[1], etudiant[2], etudiant[3]);
        }
    });

    return;
    };
});


for (var i = 0; i < document.getElementsByClassName("select-cb").length; i++) {
    document.getElementsByClassName("select-cb")[i].addEventListener("change", check_del);
}
function check_del() {
    let checkboxes = document.getElementsByClassName("select-cb");  
    var btn = document.getElementById("btn-delete");
    var nb_checked = 0;
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            nb_checked++;
            checked = true;
        }
    }
    if (checked) {
        btn.disabled = false;
        if (nb_checked == checkboxes.length){
            document.getElementById("select-all").indeterminate = false;
            document.getElementById("select-all").checked = true;
        }
        else{ 
            document.getElementById("select-all").indeterminate = true;
        }

    } else {
        btn.disabled = true;
        document.getElementById("select-all").indeterminate = false;
        document.getElementById("select-all").checked = false;
    }
};

document.getElementById("select-all").addEventListener("change", select_all);
function select_all(){
    let checkboxes = document.getElementsByClassName("select-cb");
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
        if(this.checked)
            {document.getElementById("btn-delete").disabled = false;
        }
        else {document.getElementById("btn-delete").disabled = true;}

    
    }
}



//On fait un event sur le bouton ajouter qui ajoute une tout en bas du tableau et on focus le premier input
document.getElementById("btn-add").addEventListener("click", function() {
    //On créer une ligne et on le met direct en mode edition
    console.log(add_line().getElementsByClassName("btn-edit")[0].dispatchEvent(new Event("click")));
});


function add_line(login="", nom="", prenom="", promo=""){
    var table = document.getElementsByTagName("tbody")[0];
    var tr = document.createElement("tr");
    var td = document.createElement("td");
    td.className = "select";
    var input = document.createElement("input");
    input.type = "checkbox";
    input.className = "select-cb";
    input.name = "check";
    input.addEventListener("change", check_del);
    td.appendChild(input);
    tr.appendChild(td);
    var td = document.createElement("td");
    td.className = "info login";
    td.textContent = login;
    tr.appendChild(td);
    var td = document.createElement("td");
    td.className = "info nom";
    td.textContent = nom;
    tr.appendChild(td);
    var td = document.createElement("td");
    td.className = "info prenom";
    td.textContent = prenom;
    tr.appendChild(td);
    var td = document.createElement("td");
    td.className = "info promo";
    td.textContent = promo;
    tr.appendChild(td);
    var td = document.createElement("td");
    td.className = "edit";
    var btn = document.createElement("button");
    btn.className = "btn-edit";
    btn.textContent = "Editer";
    btn.onclick = function() { edit_line(this.parentElement); };
    td.appendChild(btn);
    tr.appendChild(td);
    table.appendChild(tr);
    return tr;
}

//On fait un event sur le bouton supprimer qui supprime toutes les lignes cochées
document.getElementById("btn-delete").addEventListener("click", function() {
    let checkboxes = document.getElementsByClassName("select-cb");
    //On fait un array des checkbox à supprimer
    //On doit les mettre dans un array car on ne peut pas supprimer un element d'un array pendant qu'on le parcours
    a_supprimer = [];
    for (let i = 0; i < checkboxes.length; i++) {

        if (checkboxes[i].checked) {
            a_supprimer.push(checkboxes[i]);
        }
    }
    for (var i = 0; i < a_supprimer.length; i++) {
        //On met la tr parente en display none
        a_supprimer[i].parentElement.parentElement.style.display = "none";
        //On supprime la checkbox (pour pas qu'elle soit prise en compte dans le check_del)
        a_supprimer[i].remove();
        
    }
    check_del();
});


function edit_line(tr){
    //On desactive le bouton enregistrer
    document.getElementById("btn-save").disabled = true;
    // La touche enter click sur le bouton valider
    let btn=tr.getElementsByClassName("btn-edit")[0];
    console.log(tr)
    var tr = btn.parentNode.parentNode;
    console.log(tr)
    //On recupere les td du tr
    var td = tr.getElementsByClassName("info");
    for (var j = 0; j < td.length; j++) {
        //On recupere le contenu du td
        var content = td[j].textContent;
        //On crée un input
        var input = document.createElement("input");
        input.type = "text";
        //On lui donne la valeur du td
        input.value = content;
        //On remplace le td par l'input
        td[j].innerHTML = "";
        td[j].appendChild(input);
        //On focus le premier input (identifiant)
        if(j==0){
            input.focus();
        }
    }
    //On change le bouton en bouton de validation
    btn.textContent="Valider";
    btn.className="btn-valid";
    document.addEventListener("keypress", function(e) {if (e.keyCode == 13) {btn.click();}},{ once: true });
    btn.onclick=function(){
        if(valid_line(tr)){
            btn.textContent="Editer";
            btn.className="btn-edit";
            document.getElementById("error").textContent="";
            //Un vrai tr
            btn.onclick=function(){edit_line(tr)};
            document.getElementById("btn-save").disabled = false;
        }
    };
    //On ajoute un event listener sur la touche enter pour valider
}

function valid_line(tr){
    
    //On recupere les td du tr qui ont la classe "info"
    var td = tr.getElementsByClassName("info");

    //On vérifie que les champs ne sont pas vides
    error=Array();
    for (var j = 0; j < td.length; j++) {
        //On recupere le contenu du td
        var element=td[j].getElementsByTagName("input")[0];
        var content = element.value;
        if(content==""){           
            //On met le bordure en rouge
            element.style.border="1px solid red";
            error.push(element)
        }
    }
    if(error.length>0){
        error[0].focus();
        document.getElementById("error").textContent="Veuillez remplir tous les champs";
        //On remet le listener sur la touche enter pour revalider
        document.addEventListener("keypress", function(e) {if (e.keyCode == 13) {btn.click();}},{ once: true });
        return false;
    }
    for (var j = 0; j < td.length; j++) {
        //On recupere le contenu du td
        var content = td[j].getElementsByTagName("input")[0].value;
        //On remplace le td par le contenu
        td[j].innerHTML = content;
    }
    return true;
}

function valid_line_final(tr) {
    //Validation finale du tableau
    //Recupere les td de classe info du tr
    var td = tr.getElementsByClassName("info");
    error=false;
    //On vérifie que les champs ne sont pas vides
        for (var j = 0; j < td.length; j++) {
            //On recupere le contenu du td
            var content = td[j].textContent;
            if (content =="") {
                //On recupere le bouton "btn-edit" du tr et on lui met un event listener sur le click
                var btn = tr.getElementsByClassName("btn-edit")[0];
                btn.dispatchEvent(new Event("click"));
                error=true;
                break;
            }
        }
    if (error){
        document.getElementById("error").textContent = "Veuillez remplir tous les champs";
    }
    
    return !error;
   
}


var btns = document.getElementsByClassName("btn-edit");
for (var i = 0; i < btns.length; i++) {
    btns[i].onclick=function(){
        edit_line(this.parentElement)};
}

//On fait un event sur le bouton enrégistrer qui envoie les données au serveur en ajax
document.getElementById("btn-save").addEventListener("click", function() {
    //On recupere les lignes du tableau
    let tr = document.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    //On crée un array qui contiendra les données
    let ins_mod = Array();
    let loginChange = Array();
    let del = Array();
    for (var i = 0; i < tr.length; i++) {
        if (!valid_line_final(tr[i])){
            //Si la ligne n'est pas valide, on arrete le script
            return;
        }
        //On recupere les td du tr
        var td = tr[i].getElementsByClassName("info");
        //On crée un array qui contiendra les données de la ligne
        state='';
        var line = Array();
        if (tr[i].style.display == "none") {
            state='del';
            line.push(td[0].textContent);
        }
        for (var j = 0; j < td.length; j++) {
            //Si on detecte un element qui a un attribut data-old différent de TEXT, on est dans le cas d'une modificationS
            if(td[j].getAttribute("data-old")!=td[j].textContent){
                //Si on est dans le cas d'un changement de login, on met le state à loginChange
                if(j==0 && td[j].hasAttribute("data-old")){
                    state='loginChange';
                    line.push(td[0].getAttribute("data-old"),td[0].textContent,td[1].textContent,td[2].textContent,td[3].textContent);
                }
                //Sinon on met le state à ins_mod
                else{
                    state='ins_mod';
                    line.push(td[0].textContent,td[1].textContent,td[2].textContent,td[3].textContent);
                }
                //Dans la line on met les nouvelles données d'une traite
                
                break;//On sort de la boucle
            }
        }
            
        switch (state) {
            case 'del':
                del.push(line);
                break;
            case 'loginChange':
                loginChange.push(line);
                break;
            case 'ins_mod':
                ins_mod.push(line);
                break;
            
            default:
                break;
        }
        
    }
    // console.log(ins_mod);
    // console.log(loginChange);
    // console.log(del);
    //On envoie les données au serveur
    if(ins_mod.length>0 || loginChange.length>0 || del.length>0 ){
        $.ajax({
            url: window.location.href,
            type: "POST",
            data: { ins_mod: (ins_mod), loginChange: (loginChange) , del: (del) },
            success: function(data) {
                //Quand on reussis tous les attribut data-old sont égaux aux textContent des td
                for (var i = 0; i < tr.length; i++) {
                    var td = tr[i].getElementsByClassName("info");
                    for (var j = 0; j < td.length; j++) {
                        td[j].setAttribute("data-old",td[j].textContent);
                    }
                }
                //On affiche un message de confirmation
                alert("Les modifications ont bien été enregistrées");
            }
        });
    }

        
});





