#!/usr/bin/env bash
#To repo root
cd ..
#Zipping files in /htdocs to release.zip (excluding vendor folder and .env file)
cd htdocs && zip -r ../release.zip . -x vendor/**\* node_modules/**\* .env && cd ..
#Copy release.zip to live server
scp release.zip alessandroaussemsbe@ssh.alessandroaussems.be:subsites/dev.karel-chatbot.be/release.zip
#SSH to live server browse to directory, unzip release in the current directory, remove release.zip and install dependencies
ssh alessandroaussemsbe@ssh.alessandroaussems.be "cd subsites/dev.karel-chatbot.be && unzip -o release.zip && rm -rf release.zip && composer install"
#Clean-up remove release.zip from local system
rm -rf release.zip
#Database
#Export local database to data/ folder
/Applications/AMPPS/mysql/bin/mysqldump -u root -h localhost -proot karel > data/karel.sql
#Import from data/ folder to live database host
mysql -u ID241951_devkarel -h ID241951_devkarel.db.webhosting.be -pKdGVU5rn ID241951_devkarel < data/karel.sql