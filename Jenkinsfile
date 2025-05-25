
pipeline {
    agent any
    parameters {
                string(name: 'specificTestPath', defaultValue: '', description: '(Optional) If you dont want to run an entire directory, just add path(s) to specific tests to run separated by comma (e.g: tests/acceptance/Search/TestACest.php, tests/acceptance/Resealed/TestBCest.php)'),

                booleanParam(name: 'runResealed', defaultValue: true, description: 'Set to true to run Resealed tests'),
                booleanParam(name: 'runVendor', defaultValue: true, description: 'Set to true to run Vendor tests'),
                booleanParam(name: 'runSdCatalog', defaultValue: true, description: 'Set to true to run SdCatalog tests'),
                booleanParam(name: 'runListing', defaultValue: true, description: 'Set to true to run Listing tests'),
                booleanParam(name: 'runSearch', defaultValue: true, description: 'Set to true to run Search tests'),
                booleanParam(name: 'runFastDelivery', defaultValue: false, description: 'Set to true to run Fast Delivery Filter tests'),
                booleanParam(name: 'runHiddenCateg', defaultValue: false, description: 'Set to true to run Hidden Categories tests'),
                booleanParam(name: 'runMobile', defaultValue: false, description: 'Set to true to run Mobile tests')
    }
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
                bat 'php vendor/bin/codecept run tests/Api'
            }
        }

    }
}