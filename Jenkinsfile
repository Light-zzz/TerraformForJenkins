pipeline {
    agent { label 'SlaveNode' }

    environment {
        REPO_URL   = "https://github.com/Light-zzz/TerraformForJenkins.git"
        DEPLOY_PATH = "/var/www/html"
        SLAVE_IP    = "13.48.42.30"
        SSH_CRED    = "SlaveNode"
        SSH_USER    = "ubuntu"
    }

    stages {

        stage('Checking SCM') {
            steps {
                echo "cloning repo form github"
                git url: "${REPO_URL}"
            }
        }

        stage('Install NGINX on Slave VM') {
            steps {
                echo "Installing NGINX on remote slave..."

                sshagent (credentials: ["${SSH_CRED}"]) {
                    sh """
                        ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SLAVE_IP} '
                            sudo apt-get update -y &&
                            sudo apt-get install nginx -y &&
                            sudo systemctl enable nginx &&
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
                        # Create temp directory on remote
                        ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SLAVE_IP} 'mkdir -p /tmp/site'

                        # Copy repo files to remote VM
                        scp -o StrictHostKeyChecking=no -r ./*.html ${SSH_USER}@${SLAVE_IP}:/tmp/site/
                        scp -o StrictHostKeyChecking=no -r ./*.js ${SSH_USER}@${SLAVE_IP}:/tmp/site/
                        scp -o StrictHostKeyChecking=no -r ./*.css ${SSH_USER}@${SLAVE_IP}:/tmp/site/

                        # Move files to NGINX web root
                        ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SLAVE_IP} '
                            sudo rm -rf ${DEPLOY_PATH}/* &&
                            sudo mv /tmp/site/* ${DEPLOY_PATH}/ &&
                            sudo systemctl restart nginx
                        '
                    """
                }
            }
        }
    }

    post {
        success {
            echo "Deployment to slave VM (${SLAVE_IP}) completed successfully!"
        }
        failure {
            echo "Deployment failed!"
        }
    }
}
