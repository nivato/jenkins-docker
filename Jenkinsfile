def containerIp(container) {
    sh(
        script: "docker inspect -f {{.NetworkSettings.IPAddress}} ${container.id}",
        returnStdout: true,
    ).trim()
}

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
        stage('Docker Build'){
            steps {
                script {
                    try {
                        docker.build "nazarivato/jenkins-docker:v${env.BUILD_NUMBER}.0"
                        sh 'docker images'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Docker Build' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
        stage('Docker Run'){
            steps {
                script {
                    try {
                        docker.image("nazarivato/jenkins-docker:v${env.BUILD_NUMBER}.0").withRun('-p 9090:80') { cntr ->
                            sleep 5  // seconds
                            sh "curl -i http://${containerIp(cntr)}:80/"
                            sh "curl -i http://127.0.0.1:9090/"
                            sh "docker logs ${cntr.id}"
                        }
                        sh 'docker ps -a'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Docker Run' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
    }
}
