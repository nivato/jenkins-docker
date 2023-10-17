pipeline {
    agent any
    options {
        disableConcurrentBuilds()
        buildDiscarder(logRotator(numToKeepStr: '5', artifactNumToKeepStr: '5'))
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
