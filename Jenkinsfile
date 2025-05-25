def failedTests = []
def failedTestsPaths = []
def failedTests2ndRun = []
pipeline {
    agent any
    parameters {
        string(name: 'specificTestPath', defaultValue: '', description: '(Optional) If you dont want to run an entire directory, just add path(s) to specific tests to run separated by comma (e.g: tests/Api/AdelaPetsCest, tests/Api/AdelaUsersCest)')
        booleanParam(name: 'runPets', defaultValue: true, description: 'Set to true to run Pets store tests')
        booleanParam(name: 'runStore', defaultValue: false, description: 'Set to true to run Store tests')
        booleanParam(name: 'runUsers', defaultValue: false, description: 'Set to true to run Users tests')
    }

    

    environment {
        DISABLE_AUTH = 'true'
        DB_ENGINE    = 'sqlite'
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
        stage('Run tests (parallel)') {
            steps {
                
                script {

                    if(params.specificTestPath?.trim()){
                        echo "Running specific test(s): ${params.specificTestPath}"
                        def runSpecific = [:]

                        def testPaths = params.specificTestPath.split(',').collect { it.trim() }.findAll { it }
                        echo "${testPaths}"
                    }
                    def testSuites = [
                        [flag: params.runPets, path: 'tests/Api/AdelaPetsCest'],
                        [flag: params.runStore, path: 'tests/Api/AdelaStoreCest'],
                        [flag: params.runUsers, path: 'tests/Api/AdelaUsersCest'],
                    ]
                    testSuites.each {
                        if (it.flag) {
                            echo "Running ${it.path} tests..."
                            try {
                                def runTests = [:]
                                
                                runTests[it.path] = {
                                    def result = bat(script: "php vendor/bin/codecept run ${it.path} --html=tsl-${it.path}.html", returnStatus: true)
                                    if (result != 0) {
                                        failedTests.add("tsl-${it.path}.html")
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
        // Re-run failed tests sequentially
        stage('Re-run failed tests (sequentially)') {
            steps {
                script{
                    if (!failedTestsPaths.isEmpty()) {
                        echo "Re-running failed tests: ${failedTestsPaths}"

                        failedTestsPaths.each { testPath ->
                            def testName = testPath.tokenize('/')[-1].replace('.php', '')
                            def result = bat(script: "php vendor/bin/codecept run ${testPath} --html=tsl-${testName}.html", returnStatus: true)
                            if (result != 0) {
                                echo "Test failed again: ${testPath}"
                                failedTests2ndRun.add("tsl-RETRY-${testName}.html")
                                currentBuild.result = 'FAILED'
                            } else {
                                echo "Test passed on retry: ${testPath}"
                            }
                        }
                    } else {
                        echo "No tests to re-run."
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