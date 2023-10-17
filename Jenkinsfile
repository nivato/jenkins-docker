pipeline {
    agent any
    options {
        disableConcurrentBuilds()
    }
    triggers {
        pollSCM 'H/5 * * * *'
    }
    stages {
        stage('Debug Info'){
            steps {
                script {
                    try {
                        sh 'date'
                        sh 'env'
                        sh 'pwd'
                        sh 'ls -lah'
                        sh 'find . -type f -not -path "*/.git/*"'
                        sh 'docker --version'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Debug Info' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
    }
}
