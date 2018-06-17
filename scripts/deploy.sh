#!/usr/bin/env bash
#To repo root
cd ..
#Zipping files in /htdocs to release.zip (excluding vendor folder and .env file)
cd htdocs && zip -r ../release.zip . -x vendor/**\*  .env .gitignore .gitattributes .DS_Store && cd ..
#Copy release.zip to live server
scp release.zip alessandroaussemsbe@ssh.alessandroaussems.be:subsites/karel-chatbot.be/release.zip
#SSH to live server browse to directory, unzip release in the current directory, remove release.zip and install dependencies
ssh alessandroaussemsbe@ssh.alessandroaussems.be "cd subsites/karel-chatbot.be && unzip -o release.zip && rm -rf release.zip && composer install"
#Clean-up remove release.zip from local system
rm -rf release.zip