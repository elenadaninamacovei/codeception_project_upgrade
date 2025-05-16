pipeline {
    agent any
    stages {
        stage('Verify php version') {
            steps {
                echo 'PHP version'
                bat '''php -v'''
            }
        }
        stage('install composer'){
            steps{
                echo 'Download the installer to the current directory'
                bat '''
                    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                '''

                echo 'Verify the installer'
                bat '''php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"'''
                
                echo 'Run the installer'
                bat '''php composer-setup.php'''

                echo 'Remove the installer'
                bat '''php -r "unlink('composer-setup.php');"'''
            }
        }
        stage('verify composer version') {
            steps {
                echo 'Composer version'
                bat 'php composer.phar -v'
            }
        }

        stage('install packages') {
            steps {
                echo 'Install packages using composer'
                bat '''php composer.phar install'''
            }
        }
        stage('Build') {
            steps {
                echo 'Build test classes'
                bat 'php vendor/bin/codecept'
                bat 'php vendor/bin/codecept build'
            }
        }

        stage('Run Api tests') {
            steps{
                echo 'run test for pets'
                bat 'php vendor/bin/codecept run tests/Api/AdelaPetsCest.php'
            }
        }

    }
}