var colors = require('colors/safe');
var path = require('path');
var express = require('express');
var app = express();

app.set('port', (process.env.PORT || 3000));

app.use('/', express.static(path.join(__dirname, 'public')));

app.listen(app.get('port'), function() {
  console.log(colors.green('✔︎︎ Server started: http://localhost:' + app.get('port') + '/'));
});
