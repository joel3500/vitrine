import csv
import numpy as np

import matplotlib.pyplot as plt   #form  matplotlib.pyplot import *
import numpy as np

from matplotlib import pylab
from matplotlib import style

from numpy import arange, array, ones
from scipy import stats

import plotly.plotly as py
import plotly.graph_objs as go

#=================================================================================
#                 Definition of our functions
#=================================================================================

#=================================================================================
#   Nombre_Enregistrements_Province_Annee(province, annee)
#=================================================================================

def Nombre_Enregistrements_Province_Annee(province, annee):
    with open('Stats.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        nombre = 0;
        for row in csv_reader:
            if row[3] == province and str(annee) in row[5]:
               nombre += 1
             
    csv_file.close()
    print nombre
    return nombre

#===================
#
#===================
# https://www.youtube.com/watch?v=eirjjyP2qcQ
def Date():
    import datetime

    d = datetime.date(2017, 2, 13)
    print(d)
    
    tday = datetime.date.today()
    print(tday)

    y = tday.year
    return y

#=================================================================================
#   Nombre_Enregistrements_Sexe_Province_Annee(province, annee, sexe, salaire)
#=================================================================================

def Nombre_Enregistrements_sexe_Province_Annee(province, annee, sexe, salaire):
    with open('Stats.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        nombre = 0;
        
        for row in csv_reader:
            date = row[5]
            ann = date[6:10]
            # print ('ann = ' +str(ann)+ '\n')
            if row[3] == province and row[2] == sexe and row[4] >= salaire and annee >= int(ann):
               nombre += 1
             
    csv_file.close()
    #print nombre
    return nombre

#=============================================================================================================================
#   Enregistrements_Province(province, annee)
#=============================================================================================================================

def Enregistrements_Province_sexe_salaire(province, annees, sexe, salaire):
    Enregistrements_pro = []
    for annee in annees:
        Enregistrements_pro.append(Nombre_Enregistrements_sexe_Province_Annee(province, annee, sexe, salaire))

    return Enregistrements_pro

#=============================================================================================================================
#   Enregistrements_Province(province, annee)
#=============================================================================================================================

def Enregistrements_Province(province, annee):
    Enregistrements_pro = []
    
    for ann in annee:
        Enregistrements_pro.append(Nombre_Enregistrements_Province_Annee(province, ann))
    return Enregistrements_pro

#==============================================================================================================================
#   Toutes_Les_Enregistrements()
#==============================================================================================================================

def Toutes_Les_Enregistrements():
    AB = []
    ON = []
    QC = []
    CB = []
    NB = []
    
    provinces = ['AB', 'ON', 'QC', 'CB', 'NB']
    annees = [1980, 1982, 1984, 1986, 1988, 1990, 1992, 1994, 1996, 1998, 2000, 2002, 2004, 2006, 2008, 2010, 2012, 2014, 2016]
    
    for prov in provinces:
        if prov == 'AB':
           AB = Enregistrements_Province('AB', annees)
        elif prov == 'ON':
           ON = Enregistrements_Province('ON', annees)
        elif prov == 'QC':
           QC = Enregistrements_Province('QC', annees)
        elif prov == 'CB':
           CB = Enregistrements_Province('CB', annees)
        elif prov == 'NB':
           NB = Enregistrements_Province('NB', annees)

    return AB, ON, QC, CB, NB

#==============================================================================================================================
#   Statistiques_des_Enregistrements()
#==============================================================================================================================

def Statistiques_des_Enregistrements():
    AB, ON, QC, CB, NB = Toutes_Les_Enregistrements()
    annees = [1980, 1982, 1984, 1986, 1988, 1990, 1992, 1994, 1996, 1998, 2000, 2002, 2004, 2006, 2008, 2010, 2012, 2014, 2016]

    plt.plot(annees, AB, 'bs', label='AB')
    plt.plot(annees, ON, 'r^', label='ON')
    plt.plot(annees, QC, 'y*', label='QC')
    plt.plot(annees, CB, 'go', label='CB')
    plt.plot(annees, NB, 'k.', label='NB')
    
    #------------------------------------
    plt.title('Nombre Totales d Enregistrements faits Annuellement pour les provinces selectionnees')
    plt.ylabel('Nombre d Enregistrements ')
    plt.xlabel('Annees')
    
    plt.legend()
    plt.show()

#==============================================================================================================================
#   Statistiques_des_Enregistrements()
#==============================================================================================================================
    
def Toutes_Les_Enregistrements_sexe_salaire():
    AB = []
    ON = []
    QC = []
    CB = []
    NB = []
    
    provinces = ['AB', 'ON', 'QC', 'CB', 'NB']
    annees = [1980, 1982, 1984, 1986, 1988, 1990, 1992, 1994, 1996, 1998, 2000, 2002, 2004, 2006, 2008, 2010, 2012, 2014, 2016]
    salaire = 45000
    
    for prov in provinces:
        if prov == 'AB':
           AB = Enregistrements_Province_sexe_salaire('AB', annees, 'F', salaire)
        elif prov == 'ON':
           ON = Enregistrements_Province_sexe_salaire('ON', annees, 'F', salaire)
        elif prov == 'QC':
           QC = Enregistrements_Province_sexe_salaire('QC', annees, 'F', salaire)
        elif prov == 'CB':
           CB = Enregistrements_Province_sexe_salaire('CB', annees, 'F', salaire)
        elif prov == 'NB':
           NB = Enregistrements_Province_sexe_salaire('NB', annees, 'F', salaire)

    return AB, ON, QC, CB, NB

#==============================================================================================================================
#   Statistiques_des_Enregistrements_sexe_salaire()
#==============================================================================================================================

def Statistiques_des_Enregistrements_sexe_salaire():
    plt.style.use('ggplot')
    AB, ON, QC, CB, NB = Toutes_Les_Enregistrements_sexe_salaire()
    annees = [1980, 1982, 1984, 1986, 1988, 1990, 1992, 1994, 1996, 1998, 2000, 2002, 2004, 2006, 2008, 2010, 2012, 2014, 2016]

    plt.plot(annees, AB, 'bs', label='AB')
    plt.plot(annees, ON, 'r^', label='ON')
    plt.plot(annees, QC, 'y*', label='QC')
    plt.plot(annees, CB, 'go', label='CB')
    plt.plot(annees, NB, 'k.', label='NB')
    
    #------------------------------------
    plt.title('Nombre totale d Enregistrements faits pour les provinces selectionnees chez les Femmes dont le revenu annual est superieur a 45000')
    plt.ylabel('Nombre d Enregistrements ')
    plt.xlabel('Annees')
    
    plt.legend()
    plt.show()
    
#=================================================================================
#   
#=================================================================================

def Annees():
    annees = []
    annee_debut = input('a partir de quelle annee voulez -vous ces statistiques ? ')
    annee_fin = input('jusqu a quelle annee voulez-vous ces statistiques ? ')
    annee_fin = annee_fin+1;
    y = 0
    for x in range(annee_debut, annee_fin, 2):
        annees.append(x)
        print(annees[y])
        y += 1
        
    return annees
    
#==============================================================================================================================
#   Statistiques_des_Enregistrements()
#==============================================================================================================================
    
def Enregistrements_Personnalised_sexe_salaire():
    AB_F = []
    AB_H = []
    ON_F = []
    ON_H = []
    QC_F = []
    QC_H = []
    CB_F = []
    QC_H = []
    NB_F = []
    NB_H = []
    
    provinces = ['AB', 'ON', 'QC', 'CB', 'NB']
    annees = Annees()
    salaire = input('Vous voulez des statistiques superieur a quel salaire ? ')
    
    for prov in provinces:
        if prov == 'AB':
           AB_F = Enregistrements_Province_sexe_salaire('AB', annees, 'F', salaire)
           AB_H = Enregistrements_Province_sexe_salaire('AB', annees, 'H', salaire)
        elif prov == 'ON':
           ON_F = Enregistrements_Province_sexe_salaire('ON', annees, 'F', salaire)
           ON_H = Enregistrements_Province_sexe_salaire('ON', annees, 'H', salaire)
        elif prov == 'QC':
           QC_F = Enregistrements_Province_sexe_salaire('QC', annees, 'F', salaire)
           QC_H = Enregistrements_Province_sexe_salaire('QC', annees, 'H', salaire)
        elif prov == 'CB':
           CB_F = Enregistrements_Province_sexe_salaire('CB', annees, 'F', salaire)
           CB_H = Enregistrements_Province_sexe_salaire('CB', annees, 'H', salaire)
        elif prov == 'NB':
           NB_F = Enregistrements_Province_sexe_salaire('NB', annees, 'F', salaire)
           NB_H = Enregistrements_Province_sexe_salaire('NB', annees, 'H', salaire)
           
    return AB_F, AB_H, ON_F, ON_H, QC_F, QC_H, CB_F, CB_H, NB_F, NB_H, annees, salaire

#==============================================================================================================================
#   Statistiques_des_Enregistrements_sexe_salaire()
#==============================================================================================================================

def Statistiques_des_Enregistrements_Personnalise_sexe_salaire():
    plt.style.use('ggplot')
    AB_F, AB_H, ON_F, ON_H, QC_F, QC_H, CB_F, CB_H, NB_F, NB_H, annees, salaire = Enregistrements_Personnalised_sexe_salaire()

    plt.plot(annees, AB_F, 'rs', label='AB_femmes')
    plt.plot(annees, AB_H, 'bs', label='AB_hommes')
    
    plt.plot(annees, ON_F, 'r^', label='ON_femmes')
    plt.plot(annees, ON_H, 'b^', label='ON_hommes')
    
    plt.plot(annees, QC_F, 'r*', label='QC_femmes')
    plt.plot(annees, QC_H, 'b*', label='QC_hommes')
    
    plt.plot(annees, CB_F, 'ro', label='CB_femmes')
    plt.plot(annees, CB_H, 'bo', label='CB_hommes')
    
    plt.plot(annees, NB_F, 'r.', label='NB_femmes')
    plt.plot(annees, NB_H, 'b.', label='NB_hommes')
    
    #--------------------------------------------------
    plt.title('Nombre Enregistrements faits pour les provinces selectionnees chez les Hommes et Femmes \n' +
              'dont le revenu Annul est superieur a ' +str(salaire))
    plt.ylabel('Nombre d Enregistrements ')
    plt.xlabel('Annees')
    
    plt.legend()
    plt.show()

#=============================================================================================================================
#   Salaires_Totaux_Province()
#=============================================================================================================================

def Enregistrements_Province_salaire():
    provinces = ['AB','ON','QC','CB','NB']
    salaires = []
    salaire_AB = 0
    n_AB = 0
    salaire_ON = 0
    n_ON = 0
    salaire_QC = 0
    n_QC = 0
    salaire_CB = 0
    n_CB = 0
    salaire_NB = 0
    n_NB = 0
    
    with open('Stats.csv','r') as csv_file:
         csv_reader = csv.reader(csv_file, delimiter=';')
         nombre = 0;
         for x in range(0, 4):
             for row in csv_reader:
                 if row[3] == 'AB' and row[4] != '':
                    salaire_AB = salaire_AB + int(row[4])
                    n_AB += 1
                 elif row[3] == 'ON' and row[4] != '':
                    salaire_ON = salaire_ON + int(row[4])
                    n_ON += 1
                 elif row[3] == 'QC' and row[4] != '':
                    salaire_QC = salaire_QC + int(row[4])
                    n_QC += 1
                 elif row[3] == 'CB' and row[4] != '':
                    salaire_CB = salaire_CB + int(row[4])
                    n_CB += 1
                 elif row[3] == 'NB' and row[4] != '':
                    salaire_NB = salaire_NB + int(row[4])
                    n_NB += 1
                         
         salaire_AB = salaire_AB / n_AB
         salaire_ON = salaire_ON / n_ON
         salaire_QC = salaire_QC / n_QC
         salaire_CB = salaire_CB / n_CB
         salaire_NB = salaire_NB / n_NB
         
         salaires.append(salaire_AB)
         salaires.append(salaire_ON)
         salaires.append(salaire_QC)
         salaires.append(salaire_CB)
         salaires.append(salaire_NB)
                     
    return salaires

#===============================================================
#
#===============================================================

def Statistiques_des_Salaires_Totaux_Par_Provinces():
    plt.style.use('ggplot')
    provinces = ['AB','ON','QC','CB','NB']
    salaires = Enregistrements_Province_salaire()

    plt.bar(provinces, salaires, label='Salaires Moyens', color='b', align='center', width=0.5)
    #-----------------------------------------------------------
    plt.title('Statistiques des Salaires Moyens par Province')
    plt.ylabel('Salaires Moyens')
    plt.xlabel('Provinces')
    
    plt.legend()
    plt.show()
    
#=================================================================================
#                 Calling of our Functions
#=================================================================================

# Nombre_Enregistrements_sexe_Province_Annee('QC', 1996, 'F', 45000)

# Statistiques_des_Enregistrements()

# Statistiques_des_Enregistrements_sexe_salaire()

# Statistiques_des_Enregistrements_Personnalise_sexe_salaire()

Statistiques_des_Salaires_Totaux_Par_Provinces()

