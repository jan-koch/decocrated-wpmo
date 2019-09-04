pipeline {
    agent any
    // Pull the repo first.
    stages {
        stage( 'Checkout Repo' ) {
            steps {
                checkout scm
            }
        }
        stage( 'Deploy' ) {
            steps {
                // Run git status just to log anything outstanding.
                sh 'git status'
                script{
                    switch( env.BRANCH_NAME ) {
                        case "master":
                                sh 'vendor/bin/phploy -s production --list'
                                sh 'vendor/bin/phploy -s production'
				            break
                        case "staging":
                                sh 'vendor/bin/phploy -s staging --list'
                                sh 'vendor/bin/phploy -s staging'
				            break
                        default:
                            // Doing nothing
                            break
                    }
                }
            }
        }
    }
    // Run items after pipeline completion/failure
    post {
        always {
            // Always clearn up the directory, regardless.
            deleteDir()
        }
    }
}
