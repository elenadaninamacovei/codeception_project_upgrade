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
                    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                '''
            }
        }

    }
}