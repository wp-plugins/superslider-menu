// google analytics via mootools / domready.
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
new Asset.javascript(gaJsHost + "google-analytics.com/ga.js", {
    onload: function() {
        var pageTracker = _gat._getTracker("UA-1483438-4"); // your id here. _uacct = "UA-1483438-4";
        //also want to add the  _udn = "portfolio.daivmowbray.com";

        pageTracker._initData();
        pageTracker._trackPageview();
    }
});