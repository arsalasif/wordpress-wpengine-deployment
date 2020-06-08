


# Wordpress Automated Deployment to WPEngine

!! Contributions are welcome

## Contents

* [Requirements](#requirements)
* [Features](#features)
* [Setup](#setup)
* [Deployments](#deployments)

## Requirements:

* **Docker:**  https://docs.docker.com/get-docker/
* **SourceTree:** https://www.sourcetreeapp.com/
* **SSH Setup to connect to WPEngine:** https://wpengine.com/support/ssh-gateway/


## Features:

* Containerized Docker build.
* Separate docker services for Wordpress (**wordpress**), MySQL database (**db**), phpMyAdmin (**pma**), NGINX (**nginx**). Additionally, a container for **mysql-tunnel** to connect to external database.
* Ability to run this code with either local database, or directly connected to external database on your wpengine instance.
* Automated deployment to Development, Staging and Production.


## Setup:
 1. [Get Repository](#1-get-repository-and-upload-to-bitbucket)
 2. [Run Options](#2-run-options)
 3. [Start up Docker](#3-start-up-docker)
### 1. Get Repository and Upload to BitBucket
Download this repository and upload on your BitBucket account.
Create 3 branches:

     1. release/development
     2. release/staging
     3. release/production

You can name these branches however you like, the caveat is that `bitbucket-pipelines.yml` must be modified correspondingly for automated deployments. Finally, clone in SourceTree.

Put your wordpress website in **wordpress** folder. **Make sure you do not delete any existing files.**

You will need to edit a bunch of files to update your wpengine environment names. Namely these three variables: WPEENVNAMEDEV, WPEENVNAMESTAG, WPEENVNAMEPROD, for development, staging, and production wpengine environment names respectively.
Files that must be edited:
 1. bitbucket-pipelines.yml
 2. scripts in migration folder
 3. get_uploads.sh
 4. send_uploads.sh
 5. pull_db.sh

For NGINX, you will need to generate local certificates and trust them.
Use the `create-cert.sh` and `trust-cert.sh` scripts in certificate_scripts folder.
#### ---> Important: Get Uploads
Run `./get_uploads.sh` to sync wp-content/uploads folder from your wpengine dev server to your local repository. (Don't forget to `chmod +x get_uploads.sh` the first time only).
**Note:** Run this script everytime you take a new pull from remote repository.

### 2. Run Options
There are two main run options:

1. Run with database container and database deployed locally (also includes phpMyAdmin container), we will call it `with-local-db` for the remainder of this document.

2. Run with only wordpress container, connected to external development database. Let's call this one `with-external-db`. Note that if you use this option, you will be directly modifying the external db on your wpengine environment. **Use with caution**.

Fire up the Terminal.
Move to repository folder.
```bash
cd /path/to/repository
```
#### **Option 1: with-local-db**:
1. Rename  `docker-compose-local.yml` file to `docker-compose.yml`.
2. Rename  `wp-config-local.php` file to `wp-config.php` in wordpress folder.
```bash
cp docker-compose-local.yml docker-compose.yml
cd wordpress # Go inside wordpress folder
cp wp-config-local.php wp-config.php
cd .. # Go back to repository root
```
**Protip:** You can copy paste this entire block in terminal and it will run each command. Just press enter afterwards.
#### **Option 2: with-external-db**:
1. Rename  `docker-compose-external.yml` file to `docker-compose.yml`.
2. Rename  `wp-config-external.php` file to `wp-config.php` in wordpress folder.
```bash
cp docker-compose-external.yml docker-compose.yml
cd wordpress # Go inside wordpress folder
cp wp-config-external.php wp-config.php
cd .. # Go back to repository root
```
**Protip:** You can copy paste this entire block in terminal and it will run each command. Just press enter afterwards.
### 3. Start up Docker
Note: All commands must be executed when you have run cd to repository directory.
#### Initialization
----> Skip this step if you're using the **with-external-db** option.
Pull latest database
```bash
./pull_db.sh
```
To make things easier for next time, set an alias:
```bash
alias pulldb=./pull_db.sh
```
So instead of writing `./pull_db.sh`, simply execute `pulldb` command.

If the script doesn't execute: `chmod +x pull_db.sh` to tell your OS it's an executable file.

#### Running containers
Build the images and run the containers.
```bash
docker-compose up --build
```
or if you want to run it in detached (background) mode:
```bash
docker-compose up -d --build
```
Make sure all containers are running:
```bash
docker-compose ps
```
```bash                                                                       
wordpress  
pma                                                  
db
```
Wordpress available at: http://localhost.
phpMyAdmin available at: http://localhost:8080.
For external option, there should be no db or pma container so you will only see `wordpress` running.

**Running on different ports**
You can change the default ports in `docker-compose.yml` file. For example, 8080:80 describes local_port:container_port. You only need to change the first port to change your localhost port.

**Want to reset everything?**
```docker
docker-compose down -v
docker-compose up --build
```

Finally, test that everything works by going to http://localhost/wp-admin and entering your username/password that you have on wpengine development environment.


## Deployments:
* [1. Development](#1-development)
* [2. Staging](#2-staging)
* [3. Production](#3-production)

### 1. Development

 1. Merge/Commit code to `release/development` branch to trigger automated deployment of code.
 2. Run `./send_uploads.sh` to sync local uploads folder to wpengine development environment.
 3. Test if everything is working correctly.

#### ---> Migrating Database
 1. Check the scripts under `database-versioning`.
 2. Manually run whichever scripts need to be run through phpMyAdmin on development environment.

### 2. Staging

 * Merge code of `release/development` branch to `release/staging` to trigger automated deployment of code.
	 1. You can do this by going to `release/development` branch.
	 2. Click on `Merge`
	 3. Select source as `release/development`.
	 4. Select destination as `release/staging`.
 * Manually upload what needs to be uploaded to `wp-content/uploads` folder from development to staging through sftp.
 * Test if everything is working correctly.

### 3. Production

 * Merge code of `release/staging` branch to `release/production` to trigger automated deployment of code.
	 1. You can do this by going to `release/staging` branch.
	 2. Click on `Merge`
	 3. Select source as `release/staging`.
	 4. Select destination as `release/production`.
 * Manually upload what needs to be uploaded to `wp-content/uploads` folder from staging to production through sftp.
 * Test if everything is working correctly.
