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

#http://www.downloadexcelfiles.com/wo_en/download-list-cities-canada#.WpmQS-jOWM8
#For more information, kindly visit :  www.downloadexcelfiles.com 

#=================================================================================
#                 Definition of our functions
#=================================================================================

def Population_Ville(ville, annee):
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        for row in csv_reader:
            if row[2] == ville and annee == 2011:
               value = row[3].replace(" ", "")
               nombre = int(value)
            elif row[2] == ville and annee == 2006:
               value = row[4].replace(" ", "")
               nombre = int(value)  
    csv_file.close()
    print nombre
    return nombre

#=================================================================================
#                 Definition of our functions
#=================================================================================

def Population_Province(province, annee):
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        nombre = 0
        for row in csv_reader:
            if row[1] == province and annee == 2011:
               value = row[4].replace(" ", "")
               nombre += int(value)
            elif row[1] == province and annee == 2006:
               value = row[5].replace(" ", "") 
               nombre += int(value)
    csv_file.close()
    print nombre
    return nombre

#=======================================================
#   Provinces_Datas_List(province):
#=======================================================

def Province_Datas(province):
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        population_2011 = 0
        population_2006 = 0
        change = 0
        n_change = 0
        land_area = 0
        population_density = 0
        n_PD = 0
        land_area = 0
        
        for row in csv_reader:
            if row[1] == province:
            
               province = row[1]
              
               value1 = row[3].replace(" ", "")
               population_2011 += int(value1)
               
               value2 = row[4].replace(" ", "")
               population_2006 += int(value2)

               value3 = row[5].replace(",", ".")
               change += float(value3)
               n_change += 1
               
               value4 = row[6].replace(",", ".")
               land_area += float(value4)
               
               value5 = row[7].replace(",", ".")
               value5 = value5.replace(" ", "")
               population_density += float(value5)
               n_PD += 1

        change /= n_change
        population_density /= n_PD
        
    csv_file.close()
    print (' province = '+province+'\n population 2011 = ' +str(population_2011)+ '\n population 2006 = '+str(population_2006)+'\n change = ' +str(change)+ '\n land area = ' +str(land_area)+ '\n population density = ' +str(population_density))
    return province, population_2011, population_2006, change, land_area, population_density 

#=======================================================
#   City_Datas_List(ville):
#=======================================================

def City_Datas(ville):
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        population_2011 = 0
        population_2006 = 0
        change = 0
        
        land_area = 0
        population_density = 0
       
        land_area = 0
        
        for row in csv_reader:
            if row[2] == ville:
            
               ville = row[2]
               
               value1 = row[3].replace(" ", "")
               population_2011 += int(value1)
               
               value2 = row[4].replace(" ", "")
               population_2006 = int(value2)

               value3 = row[5].replace(",", ".")
               change = float(value3)
               
               value4 = row[6].replace(",", ".")
               value4 = value4.replace(" ", "")
               land_area = float(value4)
               
               value5 = row[7].replace(",", ".")
               value5 = value5.replace(" ", "")
               population_density = float(value5)
               
    csv_file.close()
    print (' ville = '+ville+'\n population 2011 = ' +str(population_2011)+ '\n population 2006 = '+str(population_2006)+'\n change = ' +str(change)+ '\n land area = ' +str(land_area)+ '\n population density = ' +str(population_density))
    return ville, population_2011, population_2006, change, land_area, population_density

#===================================================================================================
#
#====================================================================================================

def All_Provinces():
    provinces = []
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        for row in csv_reader:
            if row[1] != 'Province / Territory':
                provinces.append(row[1])
    csv_file.close()
    dist_provinces = Distinct_List_of(provinces)
        
    print dist_provinces    
    return dist_provinces

#===================================================================================================
# Distinct_List_of : is a function that take a table, and return a shorter table containing
# distinct element. Elements repeted only once.
# A = [1, 2, 3, 3, 6]   B = Distinct_List_of(A)   B = [1, 2, 3, 6]
#===================================================================================================

def Distinct_List_of(the_array):
    output = []
    for x in the_array:
        if x not in output:
            output.append(x)
    return output

#===================================================================================================
#
#====================================================================================================

def All_City_Population(annee):
    populations = []
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        for row in csv_reader:
            if annee == 2011 and row[3] != 'Population -2011':
               value = row[3]
               value = value.replace(" ", "")
               value = int(value)
               populations.append(value)
            elif annee == 2006 and row[4] != 'Population -2006' :
               value = row[4]
               value = value.replace(" ", "")
               value = int(value)
               populations.append(value)
    csv_file.close()
       
    #print populations    
    return populations

#===================================================================================================
#
#====================================================================================================

def All_Provinces_Population(annee):
    populations = []
    population_2011 = 0
    popultion_2006 = 0
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        for row in csv_reader:
            if annee == 2011 and row[3] != 'Population -2011':
               value = row[3]
               value = value.replace(" ", "")
               population_2011 += int(value)
               populations.append(population_2011)
               
            elif annee == 2006 and row[4] != 'Population -2006':
               value = row[4]
               value = value.replace(" ", "")  
               population_2006 += int(value)
               populations.append(population_2006)
    csv_file.close()
       
    print populations    
    return populations
#===================================================================================================
#
#====================================================================================================

def All_Cities():
    cities = []
    with open('List_of_cities_of_Canada.csv','r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        for row in csv_reader :
            if row[2] != 'Name':
               cities.append(row[2])
    csv_file.close()
        
    #print cities    
    return cities

#====================================================================================================
#
#====================================================================================================

def Ordered_City_List_2011():
    cities_2011 = All_Cities()
    pop_2011 = All_City_Population(2011)
    
    nombre = input('Combien de villes voulez-vous inclure dans le rapport ? \n')

    ord_city_2011 = []
    ord_pop_2011 = []
    ord_change = []
    ord_land_area = []
    ord_population = []
    ord_density = []
        
    for x in range(0, nombre):
        mx_2011 = max(pop_2011)
           
        index_2011 = pop_2011.index(mx_2011)

        pop = pop_2011[index_2011]
        ord_pop_2011.append(pop)

        city_2011 = cities_2011[index_2011]
        
        print('city 2011 = ' +city_2011+ ' and pop = ' +str(mx_2011)+ '\n')
        
        ord_city_2011.append(city_2011)

        pop_2011.remove(mx_2011)
        cities_2011.remove(city_2011)
        
    return ord_city_2011, ord_pop_2011, nombre

#==================================================
#
#==================================================

def Bar_Statistiques_of_High_Population_Cities():
    plt.style.use('ggplot')
    ord_city_2011, ord_pop_2011, nombre = Ordered_City_List()
    
    plt.bar(ord_city_2011, ord_pop_2011, color='b', align='center', width=0.5)

    plt.xlabel('Cities')
    plt.ylabel('Population')
    plt.title('Statistiques of '+str(nombre)+' more important Cities in term of population ')
    #plt.legend()

    plt.show()

#=================================================================================
#
#=================================================================================

def Ordered_City_List_2011_2006():
    ord_city_2011, ord_pop_2011, nombre = Ordered_City_List_2011()

    ord_pop_2006 = []
    
    for x in range(0, nombre):
        ville = ord_city_2011[x]
        ville, population_2011, population_2006, change, land_area, population_density = City_Datas(ville)
        
        ord_pop_2006.append(population_2006)
        
    return ord_city_2011, ord_pop_2011, ord_pop_2006, nombre

#=================================================================================
#
#=================================================================================

def Bar_Statistiques_of_High_Population_Cities_2011_2006():
    plt.style.use('ggplot')
    ord_city_2011, ord_pop_2011, ord_pop_2006, nombre = Ordered_City_List_2011_2006()
    
    plt.bar(ord_city_2011, ord_pop_2011, color='r', width=0.5, label='Population 2011')
    plt.bar(ord_city_2011, ord_pop_2006, color='b', width=0.5, label='Population 2006')
    
    plt.xlabel('Cities')
    plt.ylabel('Population')
    plt.title('Statistiques of '+str(nombre)+' more important Cities in term of population ')
    plt.legend()

    plt.show()

#=================================================================================
#                 Calling of our Functions
#=================================================================================

#Population_Ville('Toronto', 2011)
#Population_Ville('Timmins', 2011)

#Population_Province('Alberta', 2011)

#Province_Datas('Alberta')
#City_Datas('Ottawa')

#All_Provinces()
#All_Cities()

#All_City_Population(2006)
#Ordered_City_List_2011()


#Bar_Statistiques_of_High_Population_Cities()

Bar_Statistiques_of_High_Population_Cities_2011_2006()








