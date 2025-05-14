pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                echo 'Build..'
                sh 'php composer.phar install'
            }
        }

    }
}