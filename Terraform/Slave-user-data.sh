#!/bin/bash
set -e

# Update and install Java (Jenkins requires Java 11 or 17) in the slave VM java is must be install.
sudo apt update -y
sudo apt install -y fontconfig openjdk-17-jdk wget gnupg