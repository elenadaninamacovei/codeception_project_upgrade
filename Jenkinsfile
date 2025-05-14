pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                echo 'Build..'
                bat '''
                    composer install ./vendor/bin/codecept run
                '''
            }
        }

    }
}