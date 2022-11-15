import json

def dupliquerEtudiants(matriceScore, liste1Annees, liste2Annees):
    ''' Déterminer les étudiants à dupliquer (si nécessaire)
    Description de la méthode :
        - Si le nombre d'étudiants de 1ère année est supérieur au nombre d'étudiants de 2ème année, il faut dupliquer les étudiants de 2ème année
        - Sinon (très rare), il faut dupliquer les étudiants de 1ère année
    Qui dupliquer ?
        - Dupliquer les étudiants qui ont la moyenne de leur score associé la plus haute
    '''
    
    if len(liste1Annees) > len(liste2Annees):
        # Dupliquer les étudiants de 2ème année
        listeMoyenneScore = []
        # Calculer la moyenne des colonnes de la matrice des scores
        for i in range(len(matriceScore[0])):
            somme = 0
            for j in range(len(matriceScore)):
                somme += matriceScore[j][i]
            listeMoyenneScore.append([somme / len(matriceScore), 0])
            
        while(len(liste2Annees) < len(liste1Annees)):
            # Déterminer le nombre de filleuls minimum
            # TODO : dupliquer réellement les filleuls
            pass
    else:
        # Dupliquer les étudiants de 1ère année
        for i in range(len (matriceScore)):
            listeMoyenneScore.append([sum(matriceScore[i]) / len(matriceScore[i]), 0])
            # TODO : dupliquer réellement les parrains
            

    return matriceScore, liste1Annees, liste2Annees

def calculerDistanceReponse(reponse1eAnnee, reponse2eAnnee):
    
    nb2eAnneeVers1eAnnee = 0
    for i in reponse2eAnnee:
        if i in reponse1eAnnee:
            nb2eAnneeVers1eAnnee += 1
            
    nb1eAnneeVers2eAnnee = 0
    for i in reponse1eAnnee:
        if i in reponse2eAnnee:
            nb1eAnneeVers2eAnnee += 1

    distance = ( nb1eAnneeVers2eAnnee / len(reponse1eAnnee) ) * ( nb2eAnneeVers1eAnnee / len(reponse2eAnnee) ) 
    return distance

def creerMatriceScore(reponses1eAnnees, reponses2eAnnees):
    '''
    Crée et calcule la matrice de score d'association entre les réponses des étudiants de 1ère et 2ème année
    Les lignes correspondent aux réponses des étudiants de 1ère année
    Les colonnes correspondent aux réponses des étudiants de 2ème année
    Plus la valeur est basse, plus les étudiants sont jugés comme "compatibles" (contrainte de l'algorithme hongrois)
    '''
    
    liste1Annees = list(reponses1eAnnees.keys())
    liste2Annees = list(reponses2eAnnees.keys())
    
    # Initialisation de la matrice des scores d'association
    scoreMaximal = len(list(reponses1eAnnees.keys())[0]) # Le scoreMaximal <==> NB_QUESTIONS
    matriceScore = [[scoreMaximal for i in range(len(reponses2eAnnees))] for j in range(len(reponses1eAnnees))]
    
    # Calculer le score d'association entre chaque étudiant de 1ère année et chaque étudiant de 2ème année
    for i in range(len(reponses1eAnnees)): # Parcours des étudiants de 1ère année
        for j in range(len(reponses2eAnnees)): # Parcours des étudiants de 2ème année
            for k in range(len(reponses1eAnnees[liste1Annees[i]])):
                matriceScore[i][j] -= calculerDistanceReponse(reponses1eAnnees[liste1Annees[i]][k], reponses2eAnnees[liste2Annees[j]][k])
    
    # On arrondit les scores au centième puis on multiplie par 100 pour n'avoir que des entiers positifs
    for i in range(len(matriceScore)):
        for j in range(len(matriceScore[i])):
            matriceScore[i][j] = int(100 * round(matriceScore[i][j], 3))
    

    for i in matriceScore:
        print(i)

    matriceScore, liste1Annees, liste2Annees = dupliquerEtudiants(matriceScore, liste1Annees, liste2Annees)
    
    
    
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