const Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router');
const Routes = require('./js_routes.json');

Routing.setRoutingData(Routes);

let url = Routing.generate('homepage');

console.log(Routing);