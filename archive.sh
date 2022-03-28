#!/bin/bash

# git archive only archives things that are committed in git, make sure to commit your changes before archiving

git archive -v -o php-todolist.zip --format=zip HEAD
