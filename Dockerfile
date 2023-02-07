pipeline {
    agent any
    stages {
        stage('Deployment') {
            when {
                expression {
                    params.DEPLOY_STAGE == "Yes" || params.DEPLOY_PROD == "Yes"
                }
            }
            steps {
                script {
                    if (params.DEPLOY_STAGE == "Yes") {
                        echo "Deploying to Stage..."
                    }
                    if (params.DEPLOY_PROD == "Yes") {
                        echo "Deploying to Production..."
                    }
                }
            }
        }
    }
    options {
        buildDiscarder(logRotator(numToKeepStr: '5'))
        timeout(time: 1, unit: 'HOURS')
        timestamps()
        buildDiscarder(logRotator(numToKeepStr: '5'))
        authorization()
        buildWrappers()
        ansicolor(useEscapeCode: true)
    }
    parameters {
        choice(name: 'DEPLOY_STAGE', choices: ['Yes', 'No'], description: 'Do you want to deploy to Stage?')
        choice(name: 'DEPLOY_PROD', choices: ['Yes', 'No'], description: 'Do you want to deploy to Production?')
    }
}
