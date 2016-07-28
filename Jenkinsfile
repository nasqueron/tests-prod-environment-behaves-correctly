node('php') {
    stage 'Checkout'
    git 'https://github.com/nasqueron/tests-prod-environment-behaves-correctly.git'

    stage 'Tests'
    sh 'make test'
}
