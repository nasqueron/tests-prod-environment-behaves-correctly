node('php') {
    stage 'Checkout tests'
    git 'https://github.com/nasqueron/tests-prod-environment-behaves-correctly.git'

    stage 'Prod tests'
    sh 'make test'
}
