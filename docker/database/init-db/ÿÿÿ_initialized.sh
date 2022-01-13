#!/bin/bash

# This script add specific file, to inform that the postgres database is initialized (with initdb)

INITIALIZED_FILE=/var/lib/postgresql/data/PG_CONTAINER_INITIALIZED

touch $INITIALIZED_FILE

echo "Warning : Do not remove this file," \ 
     "it is used to detect the initialisation of the database (with initdb)" \ 
     > $INITIALIZED_FILE