if (!/WFLLURL=[^;]+/i.test(document.cookie) || /\buid=\d+/i.test(location.href)) {
    var wfllref = '';
    
    if (location.href.length > 0) {
        
        wfllref = location.href;
    
    }
    
    try {
        
        if (wfllref.length == 0 && opener.location.href.length > 0) {
            
            wfllref = opener.location.href;
        
        }
    
    } 
    
    catch (e) {
    }
    
    document.cookie = "WFLLURL=" + wfllref + ";path=/";
}