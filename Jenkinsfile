pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                echo 'Build..'
                bat '''
                    php -v
                '''
                bat '''
                    php composer.phar install
                '''
            }
        }

    }
}