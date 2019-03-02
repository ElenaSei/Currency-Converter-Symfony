const Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router');
const Routes = require('./js_routes.json');

Routing.setRoutingData(Routes);

let form_data = document.getElementById('form_data');
let result = document.getElementById('result');


form_data.addEventListener('submit', function (event) {
    event.preventDefault();
    new Promise(function (resolve, reject) {
        let url = Routing.generate('homepage');
        let xhr = new XMLHttpRequest();
        let formDate = new FormData(form_data);

        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.addEventListener('load', function (event) {

            if (this.readyState === 4){
                console.log('hi');
                if (this.status === 200 && this.statusText === 'OK'){

                    resolve(JSON.parse(this.responseText));
                } else {
                    reject(JSON.parse(this.responseText));
                }
            }
        });

        xhr.send(formDate);
    })
        .then((response) => {
            result.textContent = response;
        })
        .catch((error) => {
           console.log(error);
        })
});


