#!/usr/bin/env perl
# ##################
# Created by dnguyen
####################

use strict;
use warnings;
#use YAML::Tiny;

my	$PROCESS_ID		= "";
my	$RUN_ID			= "";

my $config			= "config.yaml";
open (CONFIG, $config) or die ("Could not open config file.");

my $count = 1;
my $infunc = 0;
my $command;
for my $line (<CONFIG>){
	chomp($line);
	if (index($line, '#') == 0){
		next;
	}elsif (substr($line, -1, 1) eq ':'){
		$infunc ++;
	}elsif($infunc){
		system $line;
	}
}
close (CONFIG);

