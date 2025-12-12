#!/bin/bash
set -e

# Update and install Java (Jenkins requires Java 11 or 17)
sudo apt update -y
sudo apt install -y fontconfig openjdk-17-jdk wget gnupg

# Add the Jenkins Debian repository and key
curl -fsSL https://pkg.jenkins.io/debian-stable/jenkins.io-2023.key | sudo tee \
  /usr/share/keyrings/jenkins-keyring.asc > /dev/null

echo "deb [signed-by=/usr/share/keyrings/jenkins-keyring.asc]" \
  https://pkg.jenkins.io/debian-stable binary/ | sudo tee \
  /etc/apt/sources.list.d/jenkins.list > /dev/null

# Update package index again after adding Jenkins repo
sudo apt update -y

# Install Jenkins
sudo apt install -y jenkins

# Enable and start Jenkins service
sudo systemctl enable jenkins
sudo systemctl start jenkins

# Show status
sudo systemctl status jenkins --no-pager

# show admin password of Jenkins service.
sudo cat /var/lib/jenkins/secrets/initialAdminPassword