#!/usr/bin/env perl
# ##################
# Created by dnguyen
################################################################################

use strict;
use warnings;
#use YAML::Tiny;

my	$PROCESS_ID		= "";
my	$RUN_ID			= "";

my $config			= "../config.yaml";
open (CONFIG, $config) or die ("Could not open config file.");

my $count = 1;
#my $infunc = false;
for my $line (<CONFIG>){
#	if ($line)
	my $test=substr($line,0,1);
	print "$count $test\n";
	$count++;
}
close (CONFIG);
