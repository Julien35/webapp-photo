module.exports = {
    extends: [
        'angular'
    ],
    rules: {
        'angular/no-service-method': 0
    },
    env: {
        "es6": true,
        "browser": true,
        "node": true,
        "mocha": true,
        "jasmine": true
    },
    ecmaFeatures: {
        "modules": true
    }
}
