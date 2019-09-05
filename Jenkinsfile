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
                                sh 'vendor/bin/phploy --sync'
                                sh 'vendor/bin/phploy -s production --fresh'
				            break
                        case "staging":
                                sh 'vendor/bin/phploy --sync'
                                sh 'vendor/bin/phploy -s staging --fresh'
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
