function URI(uri) {
    if(uri === window) return;
    if(this === window) return new URI(uri||window.location.href);
    this.parse(uri||'');
    return this;
}

$.extend(URI, {
    expression:/(((\w+):\/\/)([^\/:]*)(:(\d+))?)?([^#?]*)(\?([^#]*))?(#(.*))?/,
    decodeComponent:function(val) {
        return window.decodeURIComponent(val.replace(/\+/g,' '));
    },
    encodeComponent:function(val) {
        var c=String(val).split(/([\[\]])/);
        for(var a=0,b=c.length; a<b; a+=2)
            c[a]=window.encodeURIComponent(c[a]);
        return c.join('');
    },
    implodeQuery:function(f,e,a){
        e = e || '';
        if(a===undefined) a=true;
        var g=[];
        if(f===null||f===undefined) {
            g.push(a ? URI.encodeComponent(e):e);
        } else if(f instanceof Array) {
            for(var c=0; c<f.length; ++c)
                try{
                    if(f[c]!==undefined)g.push(URI.implodeQuery(f[c],e?(e+'['+c+']'):c));
                } catch(b){}
        } else if(typeof(f)=='object') {
            // TODO fix here
            if(false && DOM.isNode(f)){
                g.push('{node}');
            } else { 
                for(var d in f) {
                    try{
                        if(f[d]!==undefined)g.push(URI.implodeQuery(f[d],e?(e+'['+d+']'):d));
                    } catch(b) {}
                }
            }
        } else if(a) {
            g.push(URI.encodeComponent(e)+'='+URI.encodeComponent(f));
        } else g.push(e+'='+f);
        return g.join('&');
    },
    arrayQueryExpression : /^(\w+)((?:\[\w*\])+)=?(.*)/,
    explodeQuery : function(url) {
        if(!url) return {};
        var params = {};
        
        url = url.replace(/%5B/ig,'[').replace(/%5D/ig,']');
        url = url.split('&');
        
        for(var i=0, len=url.length; i < len; i++){
            var matches = url[i].match(URI.arrayQueryExpression);
            
            if(!matches){
                // cat dau = 
                var pair = url[i].split('=');
                
                params[URI.decodeComponent(pair[0])] = pair[1] === undefined ? null : URI.decodeComponent(pair[1]);
            } else {
                // phan tich param dac biet []
                var c = matches[2].split(/\]\[|\[|\]/).slice(0,-1);
                var f = matches[1];
                var k = URI.decodeComponent(matches[3] || '');
                
                c[0]=f;
                
                var tmp = params;
                for(var a=0; a<c.length-1; a++)
                    if(c[a]) {
                        if(tmp[c[a]] === undefined)
                            if(c[a+1] && !c[a+1].match(/\d+$/)) {
                                tmp[c[a]]={};
                            } else tmp[c[a] ]=[];
                        tmp = tmp[c[a]];
                    } else {
                        if(c[a+1] && !c[a+1].match(/\d+$/)) {
                            tmp.push({});
                        } else tmp.push([]);
                        tmp = tmp[tmp.length-1];
                    }
                
                if(tmp instanceof Array && c[c.length-1] == '') {
                    tmp.push(k);
                } else tmp[c[c.length-1]] = k;
            }
        }
        
        return params;
    }
});

$.extend(URI.prototype, {
    getQueryData : function(){
        return URI.explodeQuery(this.query_s);
    },
    parse : function(uri){
        var parts = uri.toString().match(URI.expression);
        
        $.extend(this, {
            protocol : parts[3]||'',
            domain : parts[4]||'',
            port : parts[6]||'',
            path : parts[7]||'',
            query_s : parts[9]||'',
            fragment : parts[11]||''
        });
        
        return this;
    },
    setDomain:function(domain){
        this.domain = domain;
        return this;
    },
    getDomain:function(){
        return this.domain;
    },
    setPort:function(port){
        this.port = port;
        return this;
    }
    ,
    getPort:function(){
        return this.port;
    },
    setProtocol:function(protocol){
        this.protocol = protocol;
        return this;
    }
    ,
    getProtocol:function(){
        return this.protocol;
    },
    setQueryData:function(a){
        this.query_s = URI.implodeQuery(a);
        return this;
    },
    getUrl : function() {
        var url='';
        this.protocol && (url += this.protocol+'://');
        this.domain && (url += this.domain);
        this.port && (url += ':'+this.port);
        if(this.domain && !this.path) url+='/';
        this.path && (url+=this.path);
        this.query_s && (url+='?'+this.query_s);
        this.fragment && (url+='#'+this.fragment);
        return url;
    },
    getQualifiedURI:function(){
        var uri = new URI(this);
        if(!uri.getDomain()){
            var alias = URI();
            uri.setProtocol(alias.getProtocol()).setDomain(alias.getDomain()).setPort(alias.getPort());
        }
        return uri;
    },
    setSubdomain:function(subdomain) {
        var qualifiedURI = new URI(this).getQualifiedURI();
        var tmp = qualifiedURI.getDomain().split('.');
        if(tmp.length <= 2){
            tmp.unshift(subdomain);
        }
        else tmp[0]=subdomain;
        return qualifiedURI.setDomain(tmp.join('.'));
    }
});


var AsyncRequest = function(uri) {
    if(uri != undefined) this.setURI(uri);
    return this;
}

// static
$.extend(AsyncRequest, {
    bootstrap : function(uri, relativeTo, method) {
        var rel = $(relativeTo).attr('rel'),
        method = method || 'GET',
        data = {};
        
        if (rel == 'async_post' || method == 'POST') {
            method = 'POST';
            if (uri) {
                data = uri.getQueryData();
                uri.setQueryData({});
            }
        }
        
        var stat_elem = $(relativeTo).parents('.stat_elem').get(0) || relativeTo;
        if ($(stat_elem).hasClass('loading-ajax')) return;
        //console.log(data);
        new AsyncRequest(uri).setMethod(method).setData(data).setStatusElement(stat_elem).setRelativeTo(relativeTo).send();
        return false;
    }
});


$.extend(AsyncRequest.prototype, {
    uri : null,
    data : {},
    method : 'GET',
    cache : false,
    async : true,
    relativeTo : null,
    statElem : null,
    handler : null,
    statusClass: '',
    finallyHandler : null,
    initialHandler : function(response) {
        return true
    },
    _replayable : true,
    
    init : function(uri) {
        if (!uri) return;
        
        this.uri = uri;
        this.handlers = [];
        this.finallyHandlers = [];
        this.data = null;
        this.relativeTo = null;
        this.statElem = null;
    },
    setAsync : function(async) {
        this.async = async; 
        return this;
    },
    setURI : function(uri) {
        this.uri = uri;
        return this;
    },
    setData : function(data) {      
        this.data = data;
        return this;
    },
    getData : function() {
        return this.data;
    },
    setMethod : function(method) {      
        this.method = method;
        return this;
    },
    setRelativeTo : function(relativeTo) {
        this.relativeTo = relativeTo;
        return this;
    }, 
    getRelativeTo : function(relativeTo) {
        return this.relativeTo;
    },
    setStatusElement : function(statElem) {
        this.statElem = statElem;
        return this;
    },
    getStatusElement : function() {
        return this.statElem;
    },
    setHandler : function(callback) {
        this.handler = callback;
        return this;
    },
    setFinallyHandler : function (callback) {
        this.finallyHandler = callback;
        return this;
    },
    setCache : function(cache) {
        this.cache = cache;
        return this;
    },
    isCache : function() {
        return this.cache;
    },
    send : function() {
        var _this = this;
        var statusElement = this.getStatusElement();
        if(statusElement){
            $(statusElement).addClass('loading-ajax');
        }

        //console.log(_this.data);
        $.ajax({
            type: _this.method,
            dataType: 'json',
            data: _this.data,
            cache: _this.cache,
            async : this.async, 
            url: _this.uri.getUrl(),                    
            success : function(response) {      
                var asyncResponse = _this.interpretResponse(response);
                _this.invokeResponseHandler(asyncResponse);
            },
            complete : function(jqXHR, textStatus) {
                _this.clearStatusIndicator();
                if (_this.finallyHandler)
                    _this.finallyHandler.call(_this, jqXHR, textStatus);                
            }
        });         
    }, 
    interpretResponse : function(response) {
        if (!response) return;
        if (response.payload && response.payload._lock_ajax && response.payload._lock_ajax == 1) tx.LOCK_AJAX = 1;

        if(typeof response.redirect != 'undefined') return {
            redirect:response.redirect
        };        
       
        var asyncResponse = new AsyncResponse(this, response);
        
        if(response.status != 1) {
            asyncResponse.payload = response;
        } else {            
            asyncResponse = $.extend(asyncResponse, response);            
        }
        
        return {
            asyncResponse:asyncResponse
        };
    },
    invokeResponseHandler : function(interp, is_replay) {
        if (!interp) return;
        
        if(typeof(interp.redirect) != 'undefined') {            
            // redirect            
            tx_go_uri(interp.redirect);
            return;
        }
     
        if( typeof(interp.asyncResponse) != 'undefined') {
            var response = interp.asyncResponse;
            if(response.getError() && !response.getErrorIsWarning()){
                this.dispatchErrorResponse(response);
            }else{
                response.setReplay(is_replay);                 
                response.css = response.css || [];
                response.js = response.js||[];    
                this.dispatchResponse(response);
            }
        }       
    },
    dispatchResponse : function(asyncResponse) {
        try {           
            this.clearStatusIndicator();
            
            if(this.initialHandler(asyncResponse) !== false){
                clearTimeout(this.timer);
                asyncResponse.jscc && invoke_callbacks([asyncResponse.jscc]);
                // goi handler
                if(this.handler)
                    try{
                        var suppress_onload = this.handler(asyncResponse);
                    } catch(exception) { }
                
                
                var onload = asyncResponse.onload;
                if(onload) {
                    for(var i=0; i<onload.length; i++) {
                        try{                                            
                            (new Function(onload[i])).apply(this);
                        } catch(e) {
                        //console.log(e);
                        //alert(e);
                        }
                    }
                }
                                      
            }            
        } catch(exception){}
    },
    dispatchErrorResponse : function(response) {
        this.clearStatusIndicator();
        var async_error = response.getError();
        
        //TODO doi ma nhan dien dialog
        if (async_error) {
            var is_confirmation = false;
            if(async_error == 1) is_confirmation = true;

            var payload = response.getPayload();
            this._displayServerDialog(payload.__dialog, is_confirmation);
        }
    },
    clearStatusIndicator:function(){
        var statusElement = this.getStatusElement();
        if(statusElement){
            $(statusElement).removeClass('loading-ajax');
        //$(statusElement).removeClass(this.statusClass);            
        }
        
    },
    _displayServerDialog : function(data, is_confirmation) {
        var dialog = new Dialog(data);
        
        var _this = this;
  
        if (is_confirmation) dialog.setHandler(function() {
            _this.data[_this.data.length] = {
                'name' : 'confirmed', 
                'value' : 1
            };
            _this.data['confirmed'] = 1;
            _this.send();
        });
        dialog.show();
    }
});

var AsyncResponse = function(request, response) {    
    this.init(request, response);
}
$.extend(AsyncResponse.prototype, {
    error : 0,
    errorSummary : null,
    errorDescription : null,
    onload : null,
    replay : false,
    payload :null,
    request: null,
    silentError : false,
    is_last : true,
    init : function(request, response) {
        $.extend(this, response);   
        this.request = request || null;
        
    },
    getRequest:function(){
        return this.request;
    }
    ,
    getPayload:function(){
        return this.payload;
    }
    ,
    getError:function(){
        return this.error;
    }
    ,
    getErrorSummary:function(){
        return this.errorSummary;
    }
    ,
    setErrorSummary:function(errorSummary){
        errorSummary = (errorSummary===undefined ? null : errorSummary);
        this.errorSummary=errorSummary;
        return this;
    }
    ,
    getErrorDescription:function(){
        return this.errorDescription;
    }
    ,
    getErrorIsWarning:function(){
        return this.errorIsWarning;
    }
    ,
    setReplay:function(isReplay){
        isReplay = (isReplay === undefined ? true : isReplay);
        this.replay=isReplay;
        return this;
    }
    ,
    isReplay:function(){
        return this.replay;
    }   
});

$('a, button').live('click', function(e) {    
    var ajaxify = $(this).attr('ajaxify');
    var href = $(this).attr('href');

    var uri = ajaxify || href;
    var rel = $(this).attr('rel');

    switch (rel) {
        case 'async':
        case 'async_post':
            AsyncRequest.bootstrap(new URI(uri), this);
            break;
        case 'anchor':
            window.location.href = href;
            break;
        default:
            return;
    }
    e.preventDefault();
});
