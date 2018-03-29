<!DOCTYPE html>
<html xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <title>My first Vue app</title>
    <script src="https://unpkg.com/vue"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css">
</head>
<body>
<div id="app">
    <p> {{ message }}</p>
    <form class="pure-form">
        <input v-on:keyup="validate" v-model="message">
    </form>
    <span v-if="!valid" style="color:red">Внимание! Не все слова с большой буквы</span>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: '',
            valid:true
        },
        methods: {
            validate: function(event) {
                this.valid = true;
                let arr = this.message.trim().split(" ");
                for (let word of arr) {
                    if (word && word[0] !== word[0].toUpperCase()) {
                        this.valid = false;
                        break;
                    }
                }
            }
        }
    })
</script>
</body>
</html>