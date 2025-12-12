Terraform AWS VPC + Jenkins Master/Slave

This project provisions an AWS VPC with two subnets, Internet Gateway, Route Table, security groups, and two EC2 instances (master and slave). The Jenkins master is installed automatically using user_data. Terraform remote state is configured to store state in an S3 bucket.

Important: Edit backend.tf to point to your S3 bucket, key, region before running terraform init.

# Apply instructions

1. Edit `backend.tf` and set your S3 bucket/key/region.
2. Replace placeholder AMI IDs in `dev.tfvars` and `prod.tfvars` to valid AMIs for your chosen region.
3. Initialize Terraform:
terraform init
4. Validate and plan (using dev):
terraform fmt terraform validate terraform plan -var-file=dev.tfvars
5. Apply (dev):
terraform apply -var-file=dev.tfvars
6. Once applied, get the Jenkins initial admin password from the master instance's cloud-init log `/var/log/jenkins_initial_admin_password` or via SSH and start configuring Jenkins.

7. To destroy when finished:
terraform destroy -var-file=dev.tfvars

Done —> I added full Terraform HCL and related files to the canvas document Terraform-aws-jenkins-infra (backend.tf, provider.tf, variables.tf, main.tf, outputs.tf, jenkins_user_data.sh, dev/prod tfvars, and README).

Open the canvas document to copy the files and run them locally. Want me to also:
* add a bootstrap Terraform module to create the S3 bucket for the backend, or
* adapt the jenkins_user_data.sh for Amazon Linux, or
* add an autoscaling group and IAM roles for Jenkins agents?