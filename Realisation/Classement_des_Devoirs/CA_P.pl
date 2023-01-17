#!/usr/bin/perl;

# Le but de ce code est faire une correction automatique de tous les devoirs des etudiants.
# A la fin les notes sont listees dans un fichier, par ordre de merite,
# et toutes les reponses des etudiants sont notes une-par-une dans des fichiers qui ont generes au cours de l<execution
# le code n est pas bien fait. je voulais juste faire un truc rapide pour retrouver la main, car j<ai tout oublie.

$devoirs[0] = "Etudiant_1.txt";
$devoirs[1] = "Etudiant_2.txt";
$devoirs[2] = "Etudiant_3.txt";
$devoirs[3] = "Etudiant_4.txt";
$devoirs[4] = "Etudiant_5.txt";
$devoirs[5] = "Etudiant_6.txt";
$devoirs[6] = "Etudiant_7.txt";
$devoirs[7] = "Etudiant_8.txt";
$devoirs[8] = "Etudiant_9.txt";
$devoirs[9] = "Etudiant_10.txt";
$devoirs[10] = "Etudiant_11.txt";
$devoirs[11] = "Etudiant_12.txt";
$devoirs[12] = "Etudiant_13.txt";
$devoirs[13] = "Etudiant_10000.txt";

#@ARGV = qw# Etudiant_1.txt Etudiant_2.txt Etudiant_3.txt Etudiant_4.txt Etudiant_5.txt Solutionnaire.txt #; # force la lecture de ces 3 fichiers

#-------------------------------------------------------------------

#@devoirs;
#print "Combien de Devoirs avez-vous a corriger ? \n";
#$nombre_dev = <STDIN>;

#for ($i = 0; $i<$nombre_dev ; $i++){
#     print "et de $i \n";
#	 $t = $i+1;
#     $devoirs[$i] = "Etudiant_"."$t".".txt";
#}

	Corriger_Devoirs(@devoirs);
 
sub Corriger_Devoirs(@_){
    @Fiche_notes = Creer_Fichiers_Corriges(@_);
	@Matrice;
	print "\n";
	#print "La Fiche des notes non classees \n";
	#print "-------------------------------------------------------------------------\n";
		#foreach $_(@Fiche_notes){
		#	print " \$_= $_ \n";
		#}
	$l = scalar (@Fiche_notes);  # gt >   lt  < ge >=  le <=
	print " In total, $l Assignments corrected \n";
	#print "-------------------------------------------------------------------------\n";
	for($i=0 ; $i<$l ; $i++){
	    #print "i= $i et Fiche = $Fiche_notes[$i] \n";  # il est la 
		$Matrice[$i][0] = $Fiche_notes[$i];
		#print " $Fiche_notes[$i]\n";         # il est la
		$extrait = $Fiche_notes[$i];
		$Matrice[$i][1] = Extraire_Note($extrait); # mais la, il est VIDE
		#print "[$Matrice[$i][0]] [$Matrice[$i][1]] \n";
	}
	
	@Triee = Trier_Matrice(@Matrice);
	print "\nThe Worksheet Classed in the order of merit :  \n";
	print "-------------------------------------------------------------------------\n";
	
	for($i=0; $i<=$l; $i++){
		print " $Triee[$i][0] \n";
	}
	
	Bilan(@Triee);
}

sub Bilan (@Triee){
    open(FILE, ">> Bilan_Des_Notes.txt ") || die "Could not open the File \n";
	    print "\n";
		print FILE "    NOTES  \n";
		print FILE "====================================================================\n";
		$l = scalar (@Triee);
		for($i=0; $i<$l ; $i++){
			print FILE " $Triee[$i][0] \n";
		}
	close(FILE) || die "Could not close the File \n";
}

sub Trier_Matrice(@Matrice){
    print "\n Sorts of Notes in descending order \n\n";
	$l = scalar (@Matrice);
	#print $l;
	$tmp[0][0] = "";
	$tmp[0][1] = "";
	for($i=0 ; $i<$l-1 ; $i++){
		for($j=$i+1; $j<$l ; $j++){
			if ($Matrice[$i][1] < $Matrice[$j][1]){
				#print "\n Ici on a une valeur a swicher \n";
				$tmp[0][0] = $Matrice[$i][0];
				$tmp[0][1] = $Matrice[$i][1];
				$Matrice[$i][0] = $Matrice[$j][0];
				$Matrice[$i][1] = $Matrice[$j][1];
				$Matrice[$j][0] = $tmp[0][0];
				$Matrice[$j][1] = $tmp[0][1];	
			}
		}
	}
	return @Matrice;
}

sub Extraire_Note($extrait){          
    #print "extract = $extrait \n";     
	$ext = $1 if $extrait =~ /= (.*) \//;
	#print "l extrait = $ext \n";
    return $ext;
}

sub Creer_Fichiers_Corriges(@_){
	@Fiche_notes = ();
    foreach $_(@_){
	    		
	    @devoir_Corrige = Corriger_1_Dev($_);
		
	    print "\n $devoir_Corrige[0] \n";	
		
		$pos = length($_) -4;
		
	    substr($_, $pos, 1,"_corrige.");	 

	    $_fichier_corrige = $_;	 
	    print "\n $_fichier_corrige    has just been created \n";
	    Reporter_Donnees_Dans_Fichier_Corrige(@devoir_Corrige, $_fichier_corrige);
		push(@Fiche_notes, $devoir_Corrige[0]);
    }   
	    print "\n\nNames and Marks of the students : \n";
		print "-------------------------------------------------------------------------\n";
	    
	foreach $note(@Fiche_notes){
		print " $note \n";
	}
	return @Fiche_notes;
}

sub Reporter_Donnees_Dans_Fichier_Corrige(@_, $_){
	open(FILE, "> $_") || die "Could not open the File $_ \n";
		foreach $ligne(@_){
			print FILE " $ligne \n";
		}
	close(FILE) || die "Could not close the File $_ \n";
}

sub Corriger_1_Dev($_){    
	my $ligne;
	my $title = "Nom de l Etudiant";
	my $first_Bar = "=================";           
	my $delimiter = "--------------------------";
	my $question = "Reponse a la question";
    #--------------------------------------------------
	my $reponse1 = "Ottawa";
	my $reponse2 = "Justin_Trudeau";
	my $reponse3 = "35";
	my $reponse4 = "Mc_Gill";
	my $reponse5_1 = "Automne";
    my $reponse5_2 = "Hiver";                
	my $reponse5_3 = "Printemps";
	my $reponse5_4 = "Ete";
	my $reponse6_1 = "32";
	my $reponse6_2 = "8";
	my $reponse6_3 = "28";
	my $reponse7 = "Hiver";
	my $reponse8 = "Ete";
	my $reponse9 = "Chlorophile";
	my $reponse10_1 = "Americain";
	my $reponse10_2 = "Marc";
	my $reponse10_3 = "Zuckerberg";
	
	my @note;
	
	open FL, "$_" || die "Probl�me d'ouverture : $! \n";
	@data = <FL>;
	close(FL);
	
    #print " @data \n";
	#print "Finished \n\n\n";
	
    my $i = 0;
	
    foreach $ligne(@data) {
	    chomp($ligne);	
	#	print " $ligne  // pour la ligne $i \n";
	
		if ($ligne =~ /$title/ or $ligne =~ /$first_Bar/ or $ligne =~ /$delimiter/ or   $ligne =~ /$question/) {
			# print "ligne pas utile \n";
			
			# je suis sur qu il y a une meilleure Facon d ecrire cette expression reguliere
			
        } else 
		{
			#print "la ligne = $ligne \n";
	 		@tableau = split(/ /, $ligne);
	 		#print "le contenu du tableau = @tableau \n";
			$i++;
            #print "-----> ligne de reponse $i \n";
			#------------------------------------
			if (grep(/^$reponse1$/, @tableau) ) {
				$note[0] = 1;
				#print "$reponse1 trouvee \n";
			}
			if (grep(/^$reponse2$/, @tableau) ) {
				$note[1] = 1;	
				#print "$reponse2 trouvee \n";
			}
			if (grep(/^$reponse3$/, @tableau) ) {
				$note[2] = 1;
				#print "$reponse3 trouvee \n";
			}
			if (grep(/^$reponse4$/, @tableau) ) {
				$note[3] = 1;
				#print "$reponse4 trouvee \n";
			}
			if (grep(/^$reponse5_1$/, @tableau) and $ligne =~ /Les 4 saisons de l annee/ ) {
				$note[4] = 1;
				#print "$reponse5_1 trouvee \n";
			}
			if (grep(/^$reponse5_2$/, @tableau) and $ligne =~ /Les 4 saisons de l annee/ ) {
				$note[5] = 1;
				#print "$reponse5_2 trouvee \n";  
			}
			if (grep(/^$reponse5_3$/, @tableau) and $ligne =~ /Les 4 saisons de l annee/ ) {
				$note[6] = 1;
				#print "$reponse5_3 trouvee \n";
			}
			if (grep(/^$reponse5_4$/, @tableau) and $ligne =~ /Les 4 saisons de l annee/ ) {
				$note[7] = 1;
				#print "$reponse5_4 trouvee \n";
			}
			if (grep(/^$reponse6_1$/, @tableau) ) {
				$note[8] = 1;
				#print "$reponse6_1 trouvee \n";
			}
			if (grep(/^$reponse6_2$/, @tableau) ) {
				$note[9] = 1;
				#print "$reponse6_2 trouvee \n";
			}
			if (grep(/^$reponse6_3$/, @tableau) ) {
				$note[10] = 1;
				#print "$reponse6_3 trouvee \n";
			}
			if (grep(/^$reponse7$/, @tableau) and $ligne =~ /La periode la plus froide/ ) {
				$note[11] = 1;
				#print "$reponse7 trouvee \n";
			}
			if (grep(/^$reponse8$/, @tableau) and $ligne =~ /La periode la plus chaude/ ) {
				$note[12] = 1;
				#print "$reponse8 trouvee \n";
			}
			if (grep(/^$reponse9$/, @tableau) ) {
				$note[13] = 1;
				#print "$reponse9 trouvee \n";
			}
			if (grep(/^$reponse10_1$/, @tableau) ) {
				$note[14] = 1;
				#print "$reponse10_1 trouvee \n";
			}
			if (grep(/^$reponse10_2$/, @tableau) ) {
				$note[15] = 1;
				#print "$reponse10_2 trouvee \n";
			}
			if (grep(/^$reponse10_3$/, @tableau) ) {
				$note[16] = 1;
				#print "$reponse10_3 trouvee \n";  
			}
		}
    } 
	
	#print "Nombre de lignes de reponses : $i /10 lignes \n";       # ON trouve souvent 11/10 qui n<est pas suppos/
	$decompte = 0;
	
	    for($j = 0; $j <= 16 ; $j++){
	        $decompte += $note[$j];
	    }
	        $l = scalar(@note);
	$lanote = "\t\t Note obtenue = $decompte / $l";
	$data[0] = $data[0].$lanote;   # ou alors  $data[0] = join("\t\t", ($data[0], $lanote));
	#-----------------------------------------------------------------------------------------
	    if($note[0] == 1){
	      $data[2]=$data[2]."\t 1/1";
	    }else{
		   $data[2]=$data[2]."\t 0/1";
	    }
	#------------------------------------------------------------------------------------------
	   if($note[1] == 1){
	      $data[6]=$data[6]."\t 1/1";
	   }else{
		  $data[6]=$data[6]."\t 0/1";
	   }
	#-------------------------------------------------------------------------------------------
	   if($note[2] == 1){
		  $data[10]=$data[10]."\t 1/1";
	   }else{
		  $data[10]=$data[10]."\t 0/1";
	   }
	#-------------------------------------------------------------------------------------------
	   if($note[3] == 1){
		  $data[14]=$data[14]."\t 1/1";
	   }else{
		  $data[14]=$data[14]."\t 0/1";
	   }
	#-------------------------------------------------------------------------------------------
	   if($note[4] == 1 and $note[5] == 1 and $note[6] == 1 and $note[7] == 1){
		  $data[18]=$data[18]."\t 4/4";
		  #-----------------------------------
	   }elsif($note[4] == 0 and $note[5] == 0 and $note[6] == 0 and $note[7] == 0){
		  $data[18]=$data[18]."\t 0/4";
		  #-----------------------------------
	   }elsif($note[4] == 0 and $note[5] == 0 and $note[6] == 0 and $note[7] == 1){
		  $data[18]=$data[18]."\t 1/4";
	   }elsif($note[4] == 0 and $note[5] == 0 and $note[6] == 1 and $note[7] == 0){
		  $data[18]=$data[18]."\t 1/4";
	   }elsif($note[4] == 0 and $note[5] == 1 and $note[6] == 0 and $note[7] == 0){
		  $data[18]=$data[18]."\t 1/4";
	   }elsif($note[4] == 1 and $note[5] == 0 and $note[6] == 0 and $note[7] == 0){
		  $data[18]=$data[18]."\t 1/4";
		  #------------------------------------
	   }elsif($note[4] == 0 and $note[5] == 0 and $note[6] == 1 and $note[7] == 1){
		  $data[18]=$data[18]."\t 2/4";
	   }elsif($note[4] == 0 and $note[5] == 1 and $note[6] == 0 and $note[7] == 1){
		  $data[18]=$data[18]."\t 2/4";
	   }elsif($note[4] == 1 and $note[5] == 0 and $note[6] == 0 and $note[7] == 1){
		  $data[18]=$data[18]."\t 2/4";
	   }elsif($note[4] == 0 and $note[5] == 1 and $note[6] == 1 and $note[7] == 0){
		  $data[18]=$data[18]."\t 2/4";
	   }elsif($note[4] == 1 and $note[5] == 1 and $note[6] == 0 and $note[7] == 0){
		  $data[18]=$data[18]."\t 2/4";
	   }elsif($note[4] == 1 and $note[5] == 0 and $note[6] == 1 and $note[7] == 0){
		  $data[18]=$data[18]."\t 2/4";
		  #-------------------------------------
	   }elsif($note[4] == 1 and $note[5] == 1 and $note[6] == 0 and $note[7] == 1){
		  $data[18]=$data[18]."\t 3/4";
	   }elsif($note[4] == 1 and $note[5] == 0 and $note[6] == 1 and $note[7] == 1){
		  $data[18]=$data[18]."\t 3/4";
	   }elsif($note[4] == 0 and $note[5] == 1 and $note[6] == 1 and $note[7] == 1){
		  $data[18]=$data[18]."\t 3/4";
	   }elsif($note[4] == 0 and $note[5] == 0 and $note[6] == 0 and $note[7] == 1){
		  $data[18]=$data[18]."\t 3/4";
	   }else {       
		  $data[18]=$data[18]."\t 3/4";
	   }
	#-------------------------------------------------------------------------------------------
	    if($note[8] == 1 and $note[9] == 1 and $note[10] == 1){
		  $data[22]=$data[22]."\t 3/3";
		}elsif($note[8] == 0 and $note[9] == 0 and $note[10] == 0){
		  $data[22]=$data[22]."\t 0/3";
	    }elsif($note[8] == 1 and $note[9] == 0 and $note[10] == 0){
		  $data[22]=$data[22]."\t 1/3";
		}elsif($note[8] == 0 and $note[9] == 1 and $note[10] == 0){
		  $data[22]=$data[22]."\t 1/3";
		}elsif($note[8] == 0 and $note[9] == 0 and $note[10] == 1){
		  $data[22]=$data[22]."\t 1/3";
		}elsif($note[8] == 1 and $note[9] == 1 and $note[10] == 0){
		  $data[22]=$data[22]."\t 2/3";
		}elsif($note[8] == 1 and $note[9] == 0 and $note[10] == 1){
		  $data[22]=$data[22]."\t 2/3";
		}else {    
		  $data[22]=$data[22]."\t 2/3";
		}
	#-------------------------------------------------------------------------------------------
	   if($note[11] == 1){
		  $data[26]=$data[26]."\t 1/1";
	   }else{
		  $data[26]=$data[26]."\t 0/1";
	   }
	#------------------------------------------------------------------------------------------
	   if($note[12] == 1){
		  $data[30]=$data[30]."\t 1/1";
	   }else{
		  $data[30]=$data[30]."\t 0/1";
	   }
	#-----------------------------------------------------------------------------------------
	   if($note[13] == 1){
		  $data[34]=$data[34]."\t 1/1";
	   }else{
		  $data[34]=$data[34]."\t 0/1";
	   }
	#-----------------------------------------------------------------------------------------
	    if($note[14] == 1 and $note[15] == 1 and $note[16] == 1){
		  $data[38]=$data[38]."\t 3/3";
		}elsif($note[14] == 0 and $note[15] == 0 and $note[16] == 0){
		  $data[38]=$data[38]."\t 0/3";
	    }elsif($note[14] == 1 and $note[15] == 0 and $note[16] == 0){
		  $data[38]=$data[38]."\t 1/3";
		}elsif($note[14] == 0 and $note[15] == 1 and $note[16] == 0){
		  $data[38]=$data[38]."\t 1/3";
		}elsif($note[14] == 0 and $note[15] == 0 and $note[16] == 1){
		  $data[38]=$data[38]."\t 1/3";
		}elsif($note[14] == 1 and $note[15] == 1 and $note[16] == 0){
		  $data[38]=$data[38]."\t 2/3";
		}elsif($note[14] == 1 and $note[15] == 0 and $note[16] == 1){
		  $data[38]=$data[38]."\t 2/3";
		}else {     
		  $data[38]=$data[38]."\t 2/3";
		}
	#-----------------------------------------------------------------------------------------
	    return @data;
}

<>;
