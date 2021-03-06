#!/usr/bin/env groovy

String[] srcPaths = ["src/"]

node {
    ansiColor('xterm') {
        def analyse
        stage('Checkout') {
            checkout scm
            analyse = load 'analyse.groovy'
        }
        stage('Pulling') {
            analyse.pull()
        }
        stage('Install dependencies') {
            analyse.composerInstall()
        }
        stage('Install dependencies') {
            analyse.prepare()
        }
        stage("Testing") {
            parallel (
                "PHPCodeSniffer": {
                    analyse.phpcs(srcPaths)
                },
                "PHPStan": {
                    analyse.phpstan(srcPaths)
                },
                "PhpMetrics": {
                    analyse.phpmetrics(srcPaths)
                },
                "PHPMessDetector": {
                    analyse.phpmd(srcPaths)
                },
                "PHPMagicNumberDetector": {
                    analyse.phpmnd(srcPaths)
                },
                "PHPCopyPasteDetector": {
                    analyse.phpcpd(srcPaths)
                }
            )
        }
    }
}
