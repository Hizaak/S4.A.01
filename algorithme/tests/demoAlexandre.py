import json
import numpy as np


def dupliquerEtudiants(matriceScore, reponses1eAnnees, reponses2eAnnees, liste1eAnnees, liste2eAnnees):
    ''' Déterminer les étudiants à dupliquer (si nécessaire)
    Description de la méthode :
        - Si le nombre d'étudiants de 1ère année est supérieur au nombre d'étudiants de 2ème année, il faut dupliquer les étudiants de 2ème année
        - Sinon (très rare), il faut dupliquer les étudiants de 1ère année
    Qui dupliquer ?
        - Dupliquer les étudiants qui ont la moyenne de leur score associé la plus basse
    '''
    dictionnaireEtudiantsADupliquer = {}
    # S'IL y a étudiants de 1ère année que d'étudiants de 2ème année, IL FAUT dupliquer les étudiants de 2ème année
    if len(reponses1eAnnees) > len(reponses2eAnnees):
        
        # Déterminer la liste des étudiants à dupliquer (ceux qui ont mis "pls")
        for i in range(len(reponses2eAnnees)):
            if reponses2eAnnees[list(reponses2eAnnees.keys())[i]][-1] == 'pls':
                # Calcul de la moyenne des scores associés à cet étudiant
                sommeScore = 0
                listeValeursADupliquer = []
                for j in range(len(matriceScore)):
                    sommeScore += matriceScore[j][i]
                    listeValeursADupliquer.append(matriceScore[j][i])

                dictionnaireEtudiantsADupliquer[list(reponses2eAnnees.keys())[i]] = [sommeScore / len(matriceScore), listeValeursADupliquer, 0]

        for i in range(len(reponses1eAnnees)-len(reponses2eAnnees)):
            
            # Trouver l'étudiant avec le moins de filleuls déjà associés et la moyenne de score associé la plus basse
            scoreMinimum = dictionnaireEtudiantsADupliquer[list(dictionnaireEtudiantsADupliquer.keys())[0]][0]
            etudiantADupliquer = list(dictionnaireEtudiantsADupliquer.keys())[0]
            niveauPriorite = dictionnaireEtudiantsADupliquer[list(dictionnaireEtudiantsADupliquer.keys())[0]][-1]
            for j in dictionnaireEtudiantsADupliquer:
                if dictionnaireEtudiantsADupliquer[j][-1] < niveauPriorite : 
                    niveauPriorite = dictionnaireEtudiantsADupliquer[j][-1]
                    scoreMinimum = dictionnaireEtudiantsADupliquer[j][0]
                    etudiantADupliquer = j
                if niveauPriorite == dictionnaireEtudiantsADupliquer[j][-1] and dictionnaireEtudiantsADupliquer[j][0] < scoreMinimum :
                    scoreMinimum = dictionnaireEtudiantsADupliquer[j][0]
                    etudiantADupliquer = j
            
            # Dupliquer l'étudiant
            for j in range(len(matriceScore)):
                matriceScore[j].append(dictionnaireEtudiantsADupliquer[etudiantADupliquer][1][j])
            dictionnaireEtudiantsADupliquer[etudiantADupliquer][-1] += 1


    # SINON, IL FAUT dupliquer les étudiants de 1ère année
    else:
        pass


    # Affichage du processus de duplication
    print("\nStructure du dictionnaire d'etudiants a dupliquer :")
    print(dictionnaireEtudiantsADupliquer)
    print("\nMatrice apres la duplication des etudiants :")
    for i in matriceScore:
        print(i)

    return matriceScore, reponses1eAnnees, reponses2eAnnees


def calculerDistanceReponse(reponse1eAnnee, reponse2eAnnee):

    nb2eAnneeVers1eAnnee = 0
    for i in reponse2eAnnee:
        if i in reponse1eAnnee:
            nb2eAnneeVers1eAnnee += 1

    nb1eAnneeVers2eAnnee = 0
    for i in reponse1eAnnee:
        if i in reponse2eAnnee:
            nb1eAnneeVers2eAnnee += 1

    distance = (nb1eAnneeVers2eAnnee / len(reponse1eAnnee)) * \
        (nb2eAnneeVers1eAnnee / len(reponse2eAnnee))
    return distance


def creerMatriceScore(reponses1eAnnees, reponses2eAnnees):
    '''
    Crée et calcule la matrice de score d'association entre les réponses des étudiants de 1ère et 2ème année
    Les lignes correspondent aux réponses des étudiants de 1ère année
    Les colonnes correspondent aux réponses des étudiants de 2ème année
    Plus la valeur est basse, plus les étudiants sont jugés comme "compatibles" (contrainte de l'algorithme hongrois)
    '''
    liste1eAnnees = list(reponses1eAnnees.keys())
    liste2eAnnees = list(reponses2eAnnees.keys())

    # Affichage des étudiants conservés
    # print("Etudiants de 1e annee (lignes) :")
    # print(liste1eAnnees)
    # print("Etudiants de 2e annee (colonnes) :")
    # print(liste2eAnnees)

    # Initialisation de la matrice des scores d'association
    # Le scoreMaximal <==> NB_QUESTIONS
    scoreMaximal = len(reponses1eAnnees[list(reponses1eAnnees.keys())[0]])
    matriceScore = [[scoreMaximal for i in range(
        len(reponses2eAnnees))] for j in range(len(reponses1eAnnees))]

    # Calculer le score d'association entre chaque étudiant de 1ère année et chaque étudiant de 2ème année
    for i in range(len(reponses1eAnnees)):  # Parcours des étudiants de 1ère année
        for j in range(len(reponses2eAnnees)):  # Parcours des étudiants de 2ème année
            for k in range(len(reponses1eAnnees[liste1eAnnees[i]])):
                matriceScore[i][j] -= calculerDistanceReponse(
                    reponses1eAnnees[liste1eAnnees[i]][k], reponses2eAnnees[liste2eAnnees[j]][k])

    # print("\nMatrice avant la rastérisation des données :")
    # for i in matriceScore:
    #     print(i)

    # On arrondit les scores au centième puis on multiplie par 100 pour n'avoir que des entiers positifs
    for i in range(len(matriceScore)):
        for j in range(len(matriceScore[i])):
            matriceScore[i][j] = int(100 * round(matriceScore[i][j], 3))

    print("\nMatrice avant la duplication des etudiants :")
    for i in matriceScore:
        print(i)

    matriceScore, liste1eAnnees, liste2eAnnees = dupliquerEtudiants(matriceScore, reponses1eAnnees, reponses2eAnnees, liste1eAnnees, liste2eAnnees)

    return matriceScore


def appliquerMethodeHongroise(matriceScore):
    pass


def associerParrainFilleul(reponses1eAnnees, reponses2eAnnees):
    matriceScore = creerMatriceScore(reponses1eAnnees, reponses2eAnnees)
    tableauAssociation = appliquerMethodeHongroise(matriceScore)

    pass


def main():
    # Ouverture du json contenant les réponses
    with open('reponses.json') as reponses:
        reponses = json.load(reponses)

    reponses1eAnnees = reponses['1annee']
    reponses2eAnnees_temp = reponses['2annee']

    # Supprimer les parrains qui ne veulent pas de filleul
    reponses2eAnnees = {}
    for i in reponses2eAnnees_temp:
        if reponses2eAnnees_temp[i][-1] != '0':
            reponses2eAnnees[i] = reponses2eAnnees_temp[i]

    associerParrainFilleul(reponses1eAnnees, reponses2eAnnees)


if __name__ == "__main__":
    main()
