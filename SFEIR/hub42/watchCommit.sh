#!/bin/bash
while [ true ]
do
	clear	
	git log -n 5 --oneline --graph --decorate --name-status
	sleep 1
done
