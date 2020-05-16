grecaptcha.ready(function() {
    grecaptcha.execute('6LdTAPgUAAAAANxnCIPfTXtwDferCQqgyFhvxnus', {action: 'login'}).then(function(token) {
        console.log(token)
        document.getElementById('captcha-response').value = token;

    });
});