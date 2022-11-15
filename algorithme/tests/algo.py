import json

#ouverture du json contenant les réponses

with open('reponses.json') as reponses:
    data = json.load(reponses)          

def associer(data):
    
    #séparation des dictionnaires de réponse, parti pris qui n'est probablement pas à prendre après réflexion

    data1 = data['1annee']  
    data2 = data['2annee']  

    #indexage des étudiants pour l'utilisation de la matrice

    lst1 = []
    lst2 = []   

    for i in data1:
        lst1.append(i)
        
    for i in data2:
        lst2.append(i)
        
    #initialisation de la matrice des scores d'association

    matAsso=[]
    for i in range(len(data1.keys())):
        matAsso.append([])
        for j in range(len(data2.keys())):
            matAsso[i].append(0)
            
    #suppression des deuxièmes années ne voulant pas de filleul
    lstASuppr = []
    for i in data2:
        if data2[i][-1]=="0":
            lstASuppr.append(i)
    for i in lstASuppr:
        data2.pop(i)
    
    #parcours des premières années
    for i in data1:    
        #parcours des deuxièmes années           
        for j in data2:
            #parcours des réponses aux questions en commun
            for k in range(len(data1[i])):   
                #si la réponse est de type list
                if type(data1[i][k])==list:   
                    #parcours de la liste du première année ou un while qui sort des qu'un jeu en commun a été trouvé
                    for indiceListe1 in range(len(data1[i][k])):  
                        #parcours de la liste du deuxième année
                        for indiceListe2 in range(len(data2[j][k])): 
                            #si un jeu en commun a été trouvé
                            if data1[i][k][indiceListe1]==data2[j][k][indiceListe2]: 
                                #incrémenter leur score d'association
                                matAsso[lst1.index(i)][lst2.index(j)] += 1  
                #si la réponse est similaire
                if data1[i][k]==data2[j][k]:  
                    #incrémenter leur score d'association
                    matAsso[lst1.index(i)][lst2.index(j)] += 1
                    
    #Remplissage de la matrice avec les deuxièmes années voulant plusieurs filleuls
    nbADupliquer=len(lstASuppr)
    #liste des index des secondes années à dupliquer
    lstADupliquer = []
    i=0
    nom=""
    while True:
        nom=lst2[i]
        if data2[nom][-1]=="pls":
            lstADupliquer.append(i)
            if len(lstADupliquer) >= nbADupliquer:
                break
        i+=1
    #duplication
    for i in lstADupliquer:
        #colonne dans laquelle il faut dupliquer le seconde année
        posDuplication=len(matAsso)-nbADupliquer
        for j in range(len(matAsso)):
            matAsso[j][posDuplication] = matAsso[j][i]
        lst2[posDuplication]=lst2[i]
        lstADupliquer.pop(0)

    #association
    dicAsso={}
    taille=len(matAsso)
    
    metHongroise(lst1, lst2, matAsso, taille)
    
    i=0
    for lala in matAsso:
        print(lala)
    for pAnnee in lst1:
        asso=[0,0,0]        # 0 : le score, 1 : la ligne, 2 : la colonne
        for j in range(taille):
            if matAsso[i][j] > asso[0]:
                asso=[matAsso[i][j], i, j]
        dicAsso[pAnnee]=lst2[asso[2]]
        for x in range(taille):
            matAsso[asso[1]][x]=-1
            matAsso[x][asso[2]]=-1
        i+=1
    
    # Afficher matrice Asso
    
    print(dicAsso)
    
    return dicAsso

def metHongroise(lst1, lst2, matAsso, taille):
    for i in range(taille):
        mini=matAsso[0][0]
        for j in range(taille):
            if mini>matAsso[i][j]:
                mini=matAsso[j][i]
        for j in range(taille):
            matAsso[i][j]-=mini
    #Selection des 0
    dicZSelec = {}
    for i in range(taille):
        for j in range(taille):
            if matAsso[i][j]==0:
                estSelec=False
                ligne=0
                position=j
                while estSelec==False and ligne<=taille:
                    if ligne<len(dicZSelec) and j==dicZSelec[ligne]:
                        estSelec=True
                    ligne+=1
                if estSelec==False:
                    dicZSelec[i]=position
    print(dicZSelec)
            

associer(data)

from random import randint
matrice=[]
for i in range (5):
    matrice.append([])
    for j in range(5):
        matrice[i].append(randint(0,10))
        
for i in matrice:
    print(i)
    