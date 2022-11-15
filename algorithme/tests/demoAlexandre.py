import json

def creerMatriceScore(reponses1Annees, reponses2Annees):
    # Initialisation de la matrice des scores d'association

    scoreMaximum = len(reponses1Annees[reponses1Annees.keys()[0]])
    print(scoreMaximum)
    matrice = [[0 for i in range(len(reponses2Annees))] for j in range(len(reponses1Annees))]
    print(matrice)




def associerParrainFilleul(reponses1Annees, reponses2Annees):
    print(reponses1Annees)
    creerMatriceScore(reponses1Annees, reponses2Annees)

    # Appliquer la méthode hongroise
    pass



def main():
    # Ouverture du json contenant les réponses
    with open('reponses.json') as reponses:
        reponses = json.load(reponses)          

    reponses1Annees = reponses['1annee']
    reponses2Annees = reponses['2annee']

    associerParrainFilleul(reponses1Annees, reponses2Annees)
    

if __name__ == "__main__":
    main()