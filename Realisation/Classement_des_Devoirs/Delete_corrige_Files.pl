#!/usr/bin/perl

use File::Copy;

for($i=1; $i<=20 ;$i++){
	unlink "Etudiant_".$i."_corrige.txt";
	 print "Etudiant_".$i."_corrige.txt   has been deleted\n\n";   # chose bizarre, ce message n apparrait pas.
}
	unlink "Etudiant_10000_corrige.txt";
	print "Etudiant_10000_corrige.txt   has been deleted\n\n";
<>;