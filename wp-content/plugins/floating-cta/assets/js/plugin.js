(function () {

    document.getElementById('cta-btn').onclick = function(e) {
        e.preventDefault();
        pageID = this.getAttribute('data-id');
        days=30; // number of days to keep the cookie
        myDate = new Date();
        myDate.setTime(myDate.getTime()+(days*24*60*60*1000));
        document.cookie = 'fcta_closed=' + pageID + '; expires=' + myDate.toGMTString() + ';';
    };

})();