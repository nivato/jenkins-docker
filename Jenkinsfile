def dockerRepo = 'nazarivato/jenkins-docker'
def dockerTag = ''
def dockerImage = ''

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
                        dockerTag = "v1.0.${env.BUILD_NUMBER}"
                        dockerImage = docker.build(
                            "${dockerRepo}:${dockerTag}",
                            "--build-arg APP_VERSION=${dockerTag} ."
                        )
                        sh 'docker images'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Docker Build' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
        stage('Test Image'){
            steps {
                script {
                    try {
                        dockerImage.withRun('-p 9090:80') { cntr ->
                            sleep 5  // seconds
                            def ipAddress = containerIp(cntr)
                            def errorLog = "/var/log/apache2/error.log"
                            def internalPortResponse = sh(
                                script: "curl -i http://${ipAddress}:80/",
                                returnStdout: true,
                            ).trim()
                            echo "internalPortResponse: ${internalPortResponse}"
                            if (!(internalPortResponse && internalPortResponse.contains(ipAddress) && internalPortResponse.contains(dockerTag))){
                                sh "docker exec ${cntr.id} /bin/sh -c 'cat ${errorLog}'"
                                sh "docker logs ${cntr.id}"
                                error("Invalid response when calling 'http://${ipAddress}:80/' URL")
                            }
                            def mappedPortResponse = sh(
                                script: "curl -i http://127.0.0.1:9090/",
                                returnStdout: true,
                            ).trim()
                            echo "mappedPortResponse: ${mappedPortResponse}"
                            if (!(mappedPortResponse && mappedPortResponse.contains(ipAddress) && mappedPortResponse.contains(dockerTag))){
                                sh "docker exec ${cntr.id} /bin/sh -c 'cat ${errorLog}'"
                                sh "docker logs ${cntr.id}"
                                error("Invalid response when calling 'http://127.0.0.1:9090/' URL")
                            }
                            sh "docker logs ${cntr.id}"
                        }
                        sh 'docker ps -a'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Test Image' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
        stage('Deploy Image'){
            steps {
                script {
                    try {
                        docker.withRegistry('', 'dockerhub_nazarivato') {
                            dockerImage.push()
                            dockerImage.push('latest')
                        }
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Deploy Image' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
        stage('Cleanup'){
            when {
                expression {
                    true  // always
                }
            }
            steps {
                script {
                    try {
                        sh "docker rmi ${dockerRepo}:${dockerTag}"
                        sh "docker rmi ${dockerRepo}:latest"
                        sh 'docker images'
                    } catch (err) {
                        echo "${err.getMessage()}"
                        error("'Cleanup' Stage Failed - ${err.getMessage()}")
                    }
                }
            }
        }
    }
}
