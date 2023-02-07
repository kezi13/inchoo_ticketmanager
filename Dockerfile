pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                echo 'Building...'
            }
        }
        stage('Deployment') {
            when {
                expression { params.DEPLOY == "Yes" }
            }
            steps {
                echo 'Deploying...'
            }
        }
        stage('Clean up') {
            when {
                expression { params.CLEANUP == "Yes" }
            }
            steps {
                echo 'Cleaning up...'
            }
        }
    }
    parameters {
        choice(name: 'DEPLOY', choices: ['Yes', 'No'], description: 'Do you want to deploy?')
        choice(name: 'CLEANUP', choices: ['Yes', 'No'], description: 'Do you want to clean up?')
    }
}
