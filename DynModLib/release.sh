#!/bin/bash

set -ex

cd ..

SEVENZIP="/c/Program Files/7-Zip/7z"

INCLUDES="-ir!DynModLib"
EXCLUDES="-xr!log.txt -xr!*.log -xr!*.suo -xr!*.pdb -xr!*.user -xr!bin -xr!obj -xr!packages -xr!.vs -xr!.git* -xr!_ignored -xr!*.zip"

"$SEVENZIP" a -tzip -mx9 DynModLib/DynModLib.zip $EXCLUDES $INCLUDES
