#!/bin/bash

# get ssh config and key file
cp /tmp/.ssh/config /root/.ssh
cp /tmp/.ssh/wpengine_rsa /root/.ssh
chown -R root:root /root/.ssh

# launch ssh tunnel
ssh -oStrictHostKeyChecking=no -4 -N -L 3306:localhost:13306 WPEENVNAMEDEV@WPEENVNAMEDEV.ssh.wpengine.net -vv

# deamonize this process so we don't lose ssh fork
while [ 0 -lt 1 ]
do
    sleep 60
done