pipeline {
    agent {lable : slave1-web}

    environment {
        REPO_URL = "https://github.com/Light-zzz/TerraformForJenkins.git"   // CHANGE
        DEPLOY_PATH = "/var/www/html"
        SLAVE_IP = "13.48.42.30"
        SSH_CRED = "ubuntu-key"     // Jenkins SSH credential ID
        SSH_USER = "ubuntu"                // VM username
    }

    stages {

        stage('checking SCM') {
            steps {
                echo "Cloning repository..."
                check SCM
            }
        }

        stage('Install NGINX on Slave VM') {
            steps {
                echo "Installing NGINX on remote slave..."

                sshagent (credentials: ["${SSH_CRED}"]) {
                    sh """
                        ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SLAVE_IP} '
                            sudo apt-get update -y
                            sudo apt-get install nginx -y
                            sudo systemctl enable nginx
                            sudo systemctl start nginx
                        '
                    """
                }
            }
        }

        stage('Copy Web Files to Slave VM') {
            steps {
                echo "Copying website files to remote NGINX server..."

                sshagent (credentials: ["${SSH_CRED}"]) {
                    sh """
                        # Copy all repo files to slave
                        scp -o StrictHostKeyChecking=no -r * ${SSH_USER}@${SLAVE_IP}:/tmp/site/

                        # Move files to NGINX directory
                        ssh ${SSH_USER}@${SLAVE_IP} '
                            sudo rm -rf ${DEPLOY_PATH}/*
                            sudo mv /tmp/site/* ${DEPLOY_PATH}/
                            sudo systemctl restart nginx
                        '
                    """
                }
            }
        }
    }

    post {
        success {
            echo "Deployment to slave VM (13.48.42.30) completed successfully!"
        }
        failure {
            echo "Deployment failed!"
        }
    }
}
