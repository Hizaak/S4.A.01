matScores = [[466, 566, 383, 483, 383, 483, 383],
             [350, 550, 400, 500, 400, 500, 400],
             [500, 300, 500, 400, 500, 400, 500],
             [500, 366, 433, 333, 433, 333, 433],
             [300, 400, 500, 400, 500, 400, 500],
             [450, 250, 600, 500, 600, 500, 600],
             [500, 350, 475, 375, 475, 375, 475]]

def afficherMatrice(matrice):
    for i in matrice:
        print(i)
        
def initMatMarque(taille):
    matMarque = []
    for i in range(taille):
        matMarque.append([])
        for j in range(taille):
            matMarque[i].append(None)
    return matMarque

def initTabCache(taille):
    tabCache=[]
    for i in range(taille):
        tabCache.append(0)
    return tabCache

def metHongroise(matScores):
    
    taille = len(matScores)
    nbSelec = 0
    matMarque = initMatMarque(taille)       # 0 si sélectionné, 1 si marqué d'un prime, sinon None   
    tabCacheL = initTabCache(taille)        # 0 si découvert, 1 si caché
    tabCacheC = initTabCache(taille)        # Idem
        
    # Soustraire la valeur minimale à chaque ligne
    for i in range(taille):
        valMin = matScores[i][0]
        for j in range(taille):
            if matScores[i][j] < valMin:
                valMin = matScores[i][j]
        for j in range(taille):
            matScores[i][j]-=valMin
            
    # Idem à chaque colonne
    for i in range(taille):
        valMin = matScores[0][i] 
        for j in range(taille):
            if matScores[j][i] < valMin:
                valMin = matScores[j][i]
        for j in range(taille):
            matScores[j][i]-=valMin
            
    # Tant tout les étudiants ne sont pas sélectionnés
    while True:
        
        # Sélection des 0
        i=0
        newZeroSelec = False
        while i < taille:
            
            # On vérifie s'il y a déjà un 0 sélectionné dans la ligne
            j=0
            aUnSelecL = False
            while j < taille:
                if matMarque[i][j] == 0:
                    aUnSelecL = True
                    break
                j+=1
            if aUnSelecL == False:
                
                # On tente de sélectionner un 0 dans la ligne
                j=0
                while j < taille:
                    if matScores[i][j] == 0:
                        
                        # On vérifie s'il y a un 0 sélectionné dans la colonne
                        k=0
                        aUnSelecC = False
                        while k < taille:
                            if matMarque[k][j] == 0:
                                aUnSelecC = True
                                break
                            k+=1
                            
                        # On sélectionne le 0
                        if aUnSelecC == False:
                            matMarque[i][j]=0
                            nbSelec+=1
                            newZeroSelec = True
                            break
                    j+=1
            i+=1
            
        # On découvre les lignes et colonnes et retire les primes
        if newZeroSelec:
            tabCacheL = initTabCache(taille)
            tabCacheC = initTabCache(taille)
            for k in range(taille):
                for l in range(taille):
                    if matMarque[k][l]==1:
                        matMarque[k][l]=None
        
        # Condition de Sortie
        if nbSelec==taille:
            break
        
        # On couvre les colonnes dont un 0 est sélectionné
        for i in range(taille):
            for j in range(taille):
                if matMarque[i][j] == 0:
                    tabCacheC[j] = 1
        print(tabCacheC)
        
        #pour le test
        nbSelec=taille
        if nbSelec==taille:
            break
        
                
    afficherMatrice(matScores)
    afficherMatrice(matMarque)
    return matScores

metHongroise(matScores)