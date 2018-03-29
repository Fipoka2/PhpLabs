<!DOCTYPE html>
<html xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
<head>
    <title>My first Vue app</title>
    <script src="https://unpkg.com/vue"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            width: 75%;
        }
    </style>

</head>
<body>
<div id="app" class="container">
    <p> {{ message }}</p>
        <input class="pure-input-1-4" v-on:keyup="validate" v-model="message">
        <button class="pure-button pure-button-primary" v-if="!valid" v-on:click="fix">Исправить</button>
    <span v-if="!valid" style="color:red">Внимание! Не все слова с большой буквы</span>
    <span v-if="valid" style="color:green">Всё в порядке</span>
    <hr>
    <select v-model="selectedSurname" v-on:change="getNames">
        <option disabled value="">Выберите один из вариантов</option>
        <option v-for="option in surnames" v-bind:value="option.value">
            {{ option.text }}
        </option>
    </select>
    <select v-if="selectedSurname" v-model="selectedName">
        <option disabled value="">Выберите один из вариантов</option>
        <option v-for="option in names" v-bind:value="option.value">
            {{ option.text }}
        </option>
    </select>
    <hr>
    <button  class="pure-button " v-on:click="fetch">get university</button>
    <ul>
        <li v-for="item in university">
            {{item.name}}
        </li>
    </ul>
    <hr>
    <button  class="pure-button pure-button-primary" v-on:click="getStudents">get students</button>
    <ul >
        <li v-for="item in students">
            {{item.surname}} - {{item.name}} - {{item.kurs}} &nbsp курс
        </li>
    </ul>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: '',
            valid:true,
            university:[],
            students:[],
            selectedName: '',
            selectedSurname: '',
            names: [''],
            surnames:['']
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
            },

            fix: function (event) {
                this.message = this.message
                    .split(' ')
                    .map(function(word) {
                        if (word.trim() !="")
                            return word[0].toUpperCase() + word.substr(1);
                        else return word;
                    })
                    .join(' ');
                this.valid = true;
            },
            
            fetch: function (event) {
                axios.get('http://localhost:8000/helloc').then((response) => {
                    this.university = response.data;
                })
            },

            getStudents: function (event) {
                axios.get('http://localhost:8000/api/rich-students').then(response => this.students = response.data);
            },

            getSurnames: function (event) {
                axios.get('http://localhost:8000/api/surnames').then(response => {
                    this.surnames = [];
                    for (let item of response.data) {
                        this.surnames.push({
                            text: item.surname,
                            value: item.surname
                        });
                    }
  //                  this.selectedSurname = this.surnames[0].value;
                });
            },

            getNames: function (event) {
                axios.post('http://localhost:8000/api/names',{surname:this.selectedSurname}).then(response => {
                    this.names = [];
                    for (let item of response.data) {
                        this.names.push({
                            text: item.name,
                            value: item.name
                        });
                    }
     //               this.selectedName = this.names[0].value;
                });
            }


        }
        
    });
    app.getSurnames();
</script>
</body>
</html>