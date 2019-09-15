(function() {
    var xmlHttp = new XMLHttpRequest(),
        scripts = document.getElementsByTagName('script'),
        lastScript = scripts[scripts.length-1],
        lastYearDate = new Date(new Date().setFullYear(new Date().getFullYear() - 1)),
        lastYear = lastYearDate.getFullYear().toString() +
            '-' + (lastYearDate.getMonth()+1).toString() +
            '-' + lastYearDate.getDate().toString(),
        url = lastScript.src
            .replace('widget', 'api/v1/reviews')
            .replace('.js', '/average?since='+lastYear);

    xmlHttp.open( "GET", url, false );
    xmlHttp.send();

    document.write(parseInt(JSON.parse(xmlHttp.responseText).avg, 10));
})();
