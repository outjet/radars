var https = require('https');

module.exports = function (context, req) {
  var options = {
    hostname: 'publicapi.ohgo.com',
    path: '/api/v1/cameras?map-bounds-sw=41.46,-81.83&map-bounds-ne=41.49,-81.75',
    method: 'GET',
    headers: {
      'Authorization': 'APIKEY 756bfc1c-746a-4a04-bc43-6c05521180e8'
    }
  };

  var fwdreq = https.request(options, function (res) {
    var data = "";
    res.on('data', (chunk) => {
      data += chunk;
    });
    res.on('end', () => {
      let response = JSON.parse(data);
      let images = "";
      for (let i = 0; i < response.results.length; i++) {
        let camera = response.results[i];
        images += "<div><img src='" + camera.cameraViews[0].smallUrl + "' alt='" + camera.description + "'><div class='caption'>" + camera.cameraViews[0].mainRoute + "</div></div>";
      }
      context.res = {
        body: images
      };
      context.done();
    });
  });

  fwdreq.on('error', function (e) {
    context.res = {
      body: 'problem with request: ' + e.message
    };
    context.done();
  });

  fwdreq.end();
};
