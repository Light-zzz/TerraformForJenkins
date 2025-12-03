pipeline {
    agent { label 'webslave' }  //Create node and change the node name

    environment {
        REPO_URL   = "https://github.com/Light-zzz/TerraformForJenkins.git" //Change the git repo paste your repo
        DEPLOY_PATH = "/var/www/html"  //This is the path where all web file moved
        SLAVE_IP    = "13.60.69.183"   //change the IP and give the slave IP 
        SSH_CRED    = "WebSlave-1"      //Change the credential of slave VM
        SSH_USER    = "ubuntu"         //This is base on ubuntu do not change the username
    }

    stages {

        stage('Checking SCM') {
            steps {
                echo "Checking out code..."
                checkout scm
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
