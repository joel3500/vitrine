#! /usr/bin/perl -w

#test file to learn how to process multiple files at once

use strict;
use warnings;
use Cwd;       #module to get the current working directory

#first get the path for current directory
my $dir = getcwd;

#declare the filehandeles outside the foreach loop
my $text_file_fh_in;
my $text_file_fh_out;

#open and read only the .txt files
opendir (DIR, $dir) or die $!;
my @textFiles = grep /\.txt/, readdir DIR;

#open each file for further processing
foreach my $text_file (@textFiles) {
    open ($text_file_fh_in, "<", $text_file) || die "$!";  #open for reading
    
    #create the names of the new files
    my $text_file_out = $text_file;
    $text_file_out =~ s/\.txt//;
    $text_file_out = $text_file_out . '_corrige.txt';
    
    open ($text_file_fh_out, ">", $text_file_out) || die "$!";  #open for writing
    
    #tests to see if it works
    #print "$text_file\n"; 
    print "$text_file_fh_in\n";
    #print "$text_file_out\n"; 
    print "$text_file_fh_out\n";
    
        MAIN: {
			while (<$text_file_fh_in>){
				chomp;
				if (/^(.*?)\.(.*?)\ (.*?)\.(.*?)\ (.*?)$/){
				print $text_file_fh_out "$1\t$2\t$4\t$5\n";} 
			}
        }
        
    #close the filehandles
    close $text_file_fh_in || die "Could not close $text_file_fh_in";  
    close $text_file_fh_out || die "Could not close $text_file_fh_out";
}

closedir DIR || die "Could not close DIR";

<>;