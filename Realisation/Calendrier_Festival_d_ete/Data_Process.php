
		<?php
		
			$xml = simplexml_load_file("Data.xml") or die("Error: Cannot create object");
			
		    Parcours_Calendrier($xml);
			
			$jour = Meilleur_Jour_Festival($xml);
			
			echo "<br> Le meilleur jour pour aller au festival d'ete est le : " .$jour. " Juillet <br><br> ";
			
			$debut_festival = 9;          // date de debut du festival d'ete
			$fin_festival = 19;           // date de fin du festival d'ete
			$intervalle = $fin_festival - $debut_festival +1;
		
			$score_clarte = 2;            /*  le score attribue a l'indice de clarte du temp. Plus il est faible, meilleur est le jour. 
			                                  C'est une valeur aleatoire que j'ai choisie, qui doit etre inferieure a tous les autres scores */
			$score_temperature = 3;       /*  le score attribue a l'indice temperature. Il est moins faible que celui du temps, 
			                                  car il est 2e en terme d'importance car c'est le beau temps qui nous attire dehors. Pour la temperature, il y a des gens qui sont moins frilleux que d'autres */
			$score_humidite = 5;          //  3e en terme d'importance
			$score_visibilite = 6;        //  4e en terme d'importance
			$score_vitesse_vent = 8;      //  5e en terme d'importance
			
			Moyennes($xml);
			   
			// Afficher_Tout($xml);
			
            function Afficher_Tout($xml){
				foreach($xml as $stationdata){
					echo $stationdata['day']." , ";
					echo $stationdata['hour']." , ";
					echo $stationdata['month']." , ";
					echo $stationdata['year']." , ";
					echo $stationdata -> temp ." , ";
					echo $stationdata -> relhum ." , ";
					echo $stationdata -> visibility ." , ";
					echo $stationdata -> weather ;
					echo " <br><br> ";
				}
			}
			
			function Parcours_Calendrier($xml){
				for($day=1 ; $day<=31 ; $day++){
					Bilan_Jour($xml, $day);
				}
			}
			
			function Bilan_Jour($xml, $day){
				$min = Minimum_Jour($xml, $day);
				    echo "La temperature minimale du jour ".$day." est de ".$min. "<br><br>";
				$max = Maximum_Jour($xml, $day);
					echo "La temperature maximale du jour ".$day." est de ".$max. "<br><br>";
				$moy = Moyenne_Jour($xml, $day);
				$moy = number_format($moy, 2, ',' , '');
					echo "La temperature moyenne du jour ".$day." est de ".$moy. "<br><br>";
					echo "<br><br>";
			}
			
			function Moyenne_Jour($xml, $day){
				$total_jour = 0;
				$compteur = 0;
				$moy_jour = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) == $day){
					    $compteur ++;
					    echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						$total_jour += $t;
					}
				}
				$moy_jour = $total_jour/$compteur;
				return $moy_jour;
			}
			
			function Maximum_Jour($xml, $day){
				$max = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) == $day){
						echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
	                    echo " max = " . $max ."<br>";
						echo " t = " . $t . "<br>";
						if($max < $t){
						   $max = $t;
						   echo "new max = " .$max. "<br>";
				        }
					}
				}
				return $max;
			}
			
			function Minimum_Jour($xml, $day){
				$min = 100;
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) == $day){
					    echo " Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						echo " min = " . $min . "<br>";
						echo " t = " . $t . "<br>";
						if($min > $t){
						   $min = $t;
						   echo "new min = " .$min. "<br>";
				        }
					}
				}
				return $min;
			}
			
			function Moyennes($xml){		
				$moy_nuit = Moyenne_Nuit($xml);
				$moy_nuit = number_format($moy_nuit, 2, ',', '');
					echo "moyenne nuit = " . $moy_nuit ."<br><br>";
					
				$moy_matin = Moyenne_Matin($xml);
				$moy_matin = number_format($moy_matin, 2, ',', '');
					echo "moyenne matin = " . $moy_matin ."<br><br>";
					
				$moy_ap_midi = Moyenne_Ap_Midi($xml);
				$moy_ap_midi = number_format($moy_ap_midi, 2, ',', '');
					echo "moyenne apres midi = " . $moy_ap_midi ."<br><br>";
				$moy_soir = Moyenne_Soir($xml);	
				$moy_soir = number_format($moy_soir, 2, ',', '');
					echo "moyenne soir = " . $moy_soir ."<br><br>";
			}
		    
			function Moyenne_Nuit($xml){
				$total_nuit = 0;
				$compteur = 0;
				$moy_nuit = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['hour']) >= 0 && intval($stationdata['hour']) < 6){
						$compteur ++;
						// echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						$total_nuit += $t;
					}
				}
				$moy_nuit = $total_nuit/$compteur;
				return $moy_nuit;
			}
			
			function Moyenne_Matin($xml){
				$total_matin = 0;
				$compteur = 0;
				$moy_matin = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['hour']) >= 6 && intval($stationdata['hour']) < 12){
						$compteur ++;
						// echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						$total_matin += $t;
					}
				}
				$moy_matin = $total_matin/$compteur;
				return $moy_matin;
			}
			 
			function Moyenne_Ap_Midi($xml){
				$total_ap_midi = 0;
				$compteur = 0;
				$moy_ap_midi = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['hour']) >= 12 && intval($stationdata['hour']) < 18){
						$compteur ++;
						// echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						$total_ap_midi += $t;
					}
				}
				$moy_ap_midi = $total_ap_midi/$compteur;
				return $moy_ap_midi;
			} 
			
			function Moyenne_Soir($xml){
				$total_soir = 0;
				$compteur = 0;
				$moy_soir = 0;
				foreach($xml as $stationdata){
					if(intval($stationdata['hour']) >= 18 && intval($stationdata['hour']) <= 23){
						$compteur ++;
						// echo "Day = " .$stationdata['day']. ", Hour = " . intval($stationdata['hour']) . " <br> ";
						$t = $stationdata -> temp;
						$total_soir += $t;
					}
				}
				$moy_soir = $total_soir/$compteur;
				return $moy_soir;
			}
			
			function Meilleur_Jour_Festival($xml){
				// On va proceder par ordre de priorite
				 				                                        
				global $fin_festival;
				global $debut_festival;
				global $intervalle;
				$jour = 0;
				$meilleurs;
				$petit = 100;                                                       // le tableau a partir duquel on determinera le meilleur jour
				
				// 1)
						$clartes_du_temp = Clartes($xml);  		 					// Ce tableau a gauche contient toutes les clartes de temps entre le jour 9 et e jour 19                                          
				// 2)	
						$temperatures = Temperatures($xml);      				    // Ce tableau a gauche contient toutes les clartes de temps entre le jour 9 et e jour 19  											
				// 3)		
						$humidites = Humidites($xml);    	                        //...									   
				// 4)							   
						$visibilites = Visibilites($xml);                           //...
				// 5)	
						$vitesses_de_vent = VitesseVents($xml);  //... 
						
			    // tableau de scores :   ce seront des tableaux a 11 entrees pour noter les jours [9 - 19] selon qu'ils valident un critere de selection.
			    // le critere le plus eleve est le critere de clarte, du coup, ces valeurs seront les plus grandes
			    // A la fin de l'enchainement, le score le plus ELEVE sera le MEILLEUR JOUR POUR ALLER AU FESTIVAL D'ETE.
			   
			            $rang_clartes = Meilleur_Clartes($clartes_du_temp);             
						
			            $rang_temperatures = Meilleur_Temperatures($temperatures); 		 // Le meilleur jour sera un jour assez chaud (temperature proche de 32) 
			            
						$rang_humidites = Meilleur_Humidites($humidites);          		 // La meilleure humidite sera une humidite basse.
						
						$rang_visibilites = Meilleur_Visibilites($visibilites);    		 // Le meilleur jour sera un jour ou il ne vente pas trop.
						
						$rang_visibilites = Meilleur_Vitesses($vitesses_de_vent);      // Le meilleur jour sera un jour a tres basse vitesse de vent
						
			    // Le jour qui aura le petit score de la somme des 5 tableaux sera le meilleur jour
					    
						for($i=0 ; $i<$intervalle ; $i++){
							$meilleurs[$i] = $rang_clartes[$i] + $rang_temperatures[$i] + $rang_humidites[$i] + $rang_visibilites[$i] + $rang_visibilites[$i];
						}
						
				// Trouvons le score du meilleur jour 
				
						for($i=0 ; $i<$intervalle ; $i++){
							if($meilleurs[$i] < $petit){
							   $petit = $meilleurs[$i];
							}
						}	
				// trouvons le jour correspondant
				        $j=0;
					    while($j<$intervalle && $meilleurs[$j] != $petit){
							if($meilleurs[$j] == $petit){
							   $jour = $j+9;
							}
						}
				return $jour;
			}
			
			function Clartes($xml){
				$clartes;   // un vecteur
				$compteur = 0;
				global $debut_festival;
				global $fin_festival;
				
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) >= $debut_festival && intval($stationdata['day']) <= $fin_festival){
					   $clarte = $stationdata -> weather;
					   $clartes[$compteur] = $clarte;
					}  $compteur ++;
				}
				return $clartes;
			}
			
			function Temperatures($xml){
				$temperatures;  
				$compteur = 0;
				global $debut_festival;
				global $fin_festival;
				
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) >= $debut_festival && intval($stationdata['day']) <= $fin_festival){
					   $temperature = $stationdata -> temperature;
					   $temperatures[$compteur] = $temperature;
					}  $compteur ++;
				}
				return $temperatures;
			}
			
			function Humidites($xml){
				$humidites;  
				$compteur = 0;
				global $debut_festival;
				global $fin_festival;
				
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) >= $debut_festival && intval($stationdata['day']) <= $fin_festival){
					   $humidite = $stationdata -> relhum;
					   $humidites[$compteur] = $humidite;
					}  $compteur ++;
				}
				return $humidites;
			}
			
			function Visibilites($xml){
				$visibilites;
				$compteur = 0;
				global $debut_festival;
				global $fin_festival;
				
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) >= $debut_festival && intval($stationdata['day']) <= $fin_festival){
					   $visibilite = $stationdata -> visibility;
					   $visibilites[$compteur] = $visibilite;
					}  $compteur ++;
				}
				return $visibilites;
			}
			
			function VitesseVents($xml){
				$vitesseVents;
				$compteur = 0;
				global $debut_festival;
				global $fin_festival;
				
				foreach($xml as $stationdata){
					if(intval($stationdata['day']) >= $debut_festival && intval($stationdata['day']) <= $fin_festival){
					   $vitesse = $stationdata -> windspd;
					   $vitesseVents[$compteur] = $vitesse;
					}  $compteur ++;
				}
				return $vitesseVents;
			}
			
			function Meilleur_Clartes($clartes_du_temp){               // Le meilleur jour sera un jour ou il ne pleut pas  < Mainly-Clear >   //
																       // ou il y a tres peu de precipites ou de brouillard
				$rang_clartes;
				global $score_clarte;   // le score affecte a la valeur Clarte. Plus le crore est bas, plus le critere est important.
				global $intervalle;
				// classement des jours selon le critere de clarte (il peut y avoir plusieurs fois 1)
				for($i=0 ; $i<$intervalle ; $i++){
					if($clartes_du_temp[$i]=='Mainly Clear'){
						$rang_clartes[$i] = 1;
					}elseif($clartes_du_temp[$i]=='NA'){              // insertitude veut dire que c'est possiblement clear.
						$rang_clartes[$i] = 2;
					}elseif($clartes_du_temp[$i]=='Cloudy'){          // quelques nuages de parts et d'autres
						$rang_clartes[$i] = 3;
					}elseif($clartes_du_temp[$i]=='Mostly Cloudy'){   // on ne voit que les nuages dans le ciel, contrairement au precedent, ou on voit quelque nuages de parts et autres
						$rang_clartes[$i] = 4;	
					}elseif($clartes_du_temp[$i]=='Fog'){
						$rang_clartes[$i] = 5;
					}elseif($clartes_du_temp[$i]=='Rain Showers'){
						$rang_clartes[$i] = 6;
					}
				}
				//scorer les clartes
				for($i=0; $i<$intervalle ; $i++){
					$rang_clartes[$i] = $score_clarte * $rang_clartes[$i];
				}
				return $rang_clartes;
			}
			
			function Meilleur_Temperatures($temperatures){
				$rang_temperatures;
				global $intervalle;
				global $score_temperature;  					    // le score affectee a la valeur temperature. Plus le score est bas, plus le critere est important.
				$tries = $temperatures;    							// le tableau trie[] nous servira a classer le tableau temperature[]
																	// la temperature ideale est la temperature proche de la temperature corporelle. 32 C
																	//   Pour mieux faire, l'ideal aurait ete de proceder avec la valeur-absolue des temperatures par rapport a 32 C.
																	//   mais selon les donnees du fichier XML, la casi-totalite des temperatures sont inferieures a 32 C.
																	//   Du coup, chercher les temperatures par ordre DECROISSANT. les plus hauts seront les meilleurs. 											   
				$tmp;
				
				// On commence par trier PAR ORDRE DECROISSANT les temperatures ressencees a l'aide du tableau de tries[].
				for($i=0; $i<$intervalle; $i++){
					for($j=($i+1) ; $j<$intervalle ; $j++){
						if($tries[$i] < $tries[$j]){
							$tmp = $trie[$i];
							$tries[$i] = $tries[$j];
							$tries[$j] = $tmp;
						}
					}
				}	
				// A chacune des positions du tableau de temperatures[], le rang sera celui de l'index du tableau tries[]
				for($i=0 ; $i<$intervalle ; $i++){
					for($j=0 ; $j<=$intervalle ; $j++){       // l'indice i c'est l indice des temperatures dans le fichier XML 
						if($temperatures[$i] == $tries[$j]){    // l'indice j c'est le RANG des temperatures.
						   $rang_temperatures[$i] = ($j+1);     // plus la temperature se raproche de 32, mieux elle est
						}
					}
				}
				// scorer les clartes
				for($i=0; $i<=$intervalle ; $i++){
					$rang_temperatures[$i] = $score_temperature * $rang_temperatures[$i];
				}
				return $rang_temperatures;
			}
			
			function Meilleur_Humidites($humidites){        // Le meilleur jour sera un jour de faible humidite. 
															// Quand il fait trop humide, les gens transpirent et c'est un peu desagreable de se rassembler, on prefere rester a la maison dans la climatisation.
				$rang_humidites;
				global $intervalle;
				global $score_humidite;                     // le score affecte a la valeur humidites. Plus le score est bas, plus le critere est important.
				$tries = $humidites;                        // le tableau trie[] nous servira a classer le tableau humidites[]
				$tmp;
				// On commence par trier PAR ORDRE CROISSANT les humidites ressencees a l'aide du tableau de trie[].
				for($i=0; $i<$intervalle ; $i++){
					for($j=($i+1) ; $j<$intervalle ; $j++){
						if($tries[$i] > $tries[$j]){
							$tmp = $trie[$i];
							$tries[$i] = $tries[$j];
							$tries[$j] = $tmp;
						}
					}
				}	
				// A chacune des positions du tableau de humidites[], le rang sera celui de l'index du tableau tries[]
				for($i=0 ; $i<$intervalle ; $i++){
					for($j=0 ; $j<=$intervalle ; $j++){       // l'indice i c'est l indice des humidites dans le fichier XML 
						if($humidites[$i] == $tries[$j]){    // l'indice j c'est le RANG des humidites.
						   $rang_humidites[$i] = ($j+1);
						}
					}
				}
				//scorer les clartes
				for($i=0; $i<=$intervalle ; $i++){
					$rang_humidites[$i] = $score_humidite * $rang_humidites[$i];
				}
				return $rang_humidites;
			}
			
			function Meilleur_Visibilites($visibilites){		// Le meilleur jour sera un jour de tres grande visibilite
																// Ca permet de voir le plus de monde possible a l'horizon
				$rang_visibilites;
				global $intervalle;
				global $score_visibilite;     					// le score affecte a la valeur visibilites. Plus le score est bas, plus le critere est important.
				$tries = $visibilites;                          // le tableau trie[] nous servira a classer le tableau visibilites[]
				$tmp;
				// On commence par trier PAR ORDRE DECROISSANT les visibilites ressencees a l'aide du tableau de trie[].
				for($i=0; $i<$intervalle ; $i++){
					for($j=($i+1) ; $j<$intervalle ; $j++){
						if($tries[$i] < $tries[$j]){
						   $tmp = $trie[$i];
						   $tries[$i] = $tries[$j];
						   $tries[$j] = $tmp;
						}
					}
				}	
				// A chacune des positions du tableau de temperatures[], le rang sera celui de l'index du tableau tries[]
				for($i=0 ; $i<$intervalle ; $i++){
					for($j=0 ; $j<=$intervalle ; $j++){       // l'indice i c'est l indice des temperatures dans le fichier XML 
						if($visibilites[$i] == $tries[$j]){    // l'indice j c'est le RANG des temperatures.
						   $rang_visibilites[$i] = ($j+1);
						}
					}
				}
				//scorer les clartes
				for($i=0; $i<=$intervalle ; $i++){
					$rang_visibilites[$i] = $score_visibilite * $rang_visibilites[$i];
				}
				return $rang_visibilites;
			}
			
			function Meilleur_Vitesses($vitesses_de_vent){		// Le meilleur jour sera un jour de faible vitesse
																// Ca permet de voir le plus de monde possible a l'horizon
				$rang_vitesses;
				global $intervalle;
				global $score_vitesse_vent;     					// le score affecte a la valeur visibilites. Plus le score est bas, plus le critere est important.
				$tries = $vitesses_de_vent;                          // le tableau trie[] nous servira a classer le tableau visibilites[]
				$tmp;
				// On commence par trier PAR ORDRE CROISSANT les visibilites ressencees a l'aide du tableau de trie[].
				for($i=0; $i<$intervalle ; $i++){
					for($j=($i+1) ; $j<$intervalle ; $j++){
						if($tries[$i] > $tries[$j]){
						   $tmp = $trie[$i];
						   $tries[$i] = $tries[$j];
						   $tries[$j] = $tmp;
						}
					}
				}	
				// A chacune des positions du tableau de temperatures[], le rang sera celui de l'index du tableau tries[]
				for($i=0 ; $i<$intervalle ; $i++){
					for($j=0 ; $j<=$intervalle ; $j++){       // l'indice i c'est l indice des temperatures dans le fichier XML 
						if($vitesses_de_vent[$i] == $tries[$j]){    // l'indice j c'est le RANG des temperatures.
						   $rang_vitesses[$i] = ($j+1);
						}
					}
				}
				//scorer les clartes
				for($i=0; $i<=$intervalle ; $i++){
					$rang_vitesses[$i] = $score_vitesse_vent * $rang_vitesses[$i];
				}
				return $rang_vitesses;
			}
		?>