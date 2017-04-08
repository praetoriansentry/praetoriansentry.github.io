#!/bin/bash

curl 'http://hilliardquotes.tumblr.com/api/read/json?start=0&debug=1' | jq '.' > raw-data.0.json
curl 'http://hilliardquotes.tumblr.com/api/read/json?start=20&debug=1' | jq '.' > raw-data.1.json
curl 'http://hilliardquotes.tumblr.com/api/read/json?start=40&debug=1' | jq '.' > raw-data.2.json
curl 'http://hilliardquotes.tumblr.com/api/read/json?start=60&debug=1' | jq '.' > raw-data.3.json

cat *.json | jq --raw-output '.posts[] | [."unix-timestamp", ."quote-text", ."quote-source"] | @tsv' | sed 's/^"//' | sed 's/"$//' > data.tsv

cat data.tsv | parallel --colsep "\t" "echo -n {2} > {1}.txt"
cat data.tsv | parallel --colsep "\t" "echo -e \"\n\nFrom:\n\" >> {1}.txt"
cat data.tsv | parallel --colsep "\t" "echo -n {3} >> {1}.txt"
