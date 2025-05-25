
pipeline {
    agent any
    parameters {
                booleanParam(name: 'runPets', defaultValue: true, description: 'Set to true to run Pets store tests')
                booleanParam(name: 'runStore', defaultValue: false, description: 'Set to true to run Store tests')
                booleanParam(name: 'runUsers', defaultValue: false, description: 'Set to true to run Users tests')
    }
    
    def failedTests = []
    def failedTestsPaths = []
    def failedTests2ndRun = []

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
                bat 'php vendor/bin/codecept run tests/Api/AdelaPetsCest'
            }
        }
        stage('Run tests (parallel)') {
            steps {
                
                script {
                    def testSuites = [
                        [flag: params.runPets, path: 'tests/Api/AdelaPetsCest'],
                        [flag: params.runStore, path: 'tests/acceptance/AdelaStoreCest'],
                        [flag: params.runUsers, path: 'tests/acceptance/AdelaUsersCest'],
                    ]
                    testSuites.each {
                        if (it.flag) {
                            echo "Running ${it.path} tests..."
                            try {
                                def runTests = [:]

                                def testName = it.path.tokenize('/')[-1].replace('.php', '')
                                runTests[it.path] = {
                                    def result = bat(script: "php vendor/bin/codecept run ${it.path} --html=tsl-${testName}.html", returnStatus: true)
                                    if (result != 0) {
                                        failedTests.add("tsl-${testName}.html")
                                        failedTestsPaths.add(it.path)
                                    }
                                }
                                parallel runTests

                                if (!failedTestsPaths.isEmpty()){
                                    echo "Some tests failed: ${failedTestsPaths}"
                                }
                            } catch (Exception e) {
                                echo "Error when running tests in ${it.path}: ${e.getMessage()}"
                                currentBuild.result = 'FAILED'
                            }

                        } else {
                            echo "Skipping ${it.path} tests..."
                        }
                    }
                }
            }
        }
        stage('Generate HTML report') {
            steps{
                script {
                    try {
                        publishHTML(target:[
                            allowMissing: false,
                            alwaysLinkToLastBuild: true,
                            keepAll: true,
                            reportDir: 'tests/_output/',
                            reportFiles: 'tsl-*.html',
                            reportName: "TSL-FRONT-tests-report-${env.BUILD_NUMBER}",
                            reportTitles: "TSL-FRONT-tests-report-${env.BUILD_NUMBER}"
                        ])
                    } catch (Exception e) {
                        echo "Error when generating report: ${e.getMessage()}"
                        currentBuild.result = 'UNSTABLE'
                    }
                }
            }
        }

    }
}