var Cooldown = {
    timeout_list: {},
    init: function(_time, _id) {
        if (this.timeout_list[_id] != null && this.timeout_list[_id] != undefined) {
            var _timeout = this.timeout_list[_id];
            clearTimeout(_timeout);
            this.timeout_list[_id] = null;
        }
        $("#cooldown_list").append("<li>Nâng cấp: <span class='fRight' id='cooldown_" + _id + "'></span></li>");
        $("#cooldown_info").removeClass("dpn");
        Cooldown.run(_time, _id);
    },
    run: function(_time, _id) {
        if(_time <= 0) {
            $("#cooldown_" + _id).html("0:00:00");
            $("#cooldown_" + _id).parents("li").fadeOut(500, function() {
                $(this).remove();
            });
            if (this.timeout_list[_id] != null && this.timeout_list[_id] != undefined) {
                var _timeout = this.timeout_list[_id];
                clearTimeout(_timeout);
                this.timeout_list[_id] = null;
                return;
            }
        }
        var _last_time = _time - 500;
        _time = Math.floor(_time / 1000);
        var _second = _time % 60;
        _time = Math.floor(_time / 60);
        var _minute = Math.floor(_time % 60);
        var _hour = Math.floor(_time / 60);
        var _html = _hour + ':' + (_minute < 10 ? '0' + _minute : _minute) + ':' + (_second < 10 ? '0' + _second : _second);

        $("#cooldown_" + _id).html(_html);
        this.timeout_list[_id] = setTimeout(function() {
            Cooldown.run(_last_time, _id);
        }, 500);
        console.log(this.timeout_list);
    }
}

var show_alert = function (msg, options) {
    var _default = {
        header: 'Thông Báo',
        btnOk: 'Đồng ý',
        callback : function() {}
    };
    _default.html = '\
        <div class="lightbox ma20 blueColor">'
    + '<div class="lbTop"></div>'
    + '<div class="lbMid por">'
    + '<h3 class="fs24 mb20">' + _default.header + '</h3>'
    + '<div class="clear"></div>'
    + '<div class="lbContent">'
    + '<div class="lbBody">'
    + '<div class="lbLine mb20"></div>'
    + '<div class="lbMainBody"><p class="lbDescTitle fwb">' + msg + '</p></div>'
    + '</div>'
    + '<div class="lbFooter mt10">'
    + '<button class="uiBtn uiBtn1 fRight mr10" id="btn_colorbox_close">' + _default.btnOk + '</button>'
    + '<div class="clear"></div>'
    + '</div>'
    + '</div>'
    + '<div class="lbPen"></div>'
    + '</div>'
    + '<div class="lbBot"></div>'
    + '</div>';	

    $.extend(_default, options);

    $.colorbox({
        close: 'x',
        transition: 'none',
        scrolling: false,
        html: _default.html,
        onClosed: function() {
            _default.callback();
        }
    });

    $('#btn_colorbox_close').click(function(e) {
        $.colorbox.close();
        e.preventDefault();
    });
};

/**
 * Show confirm dialog
 */
var show_confirm = function (params) {
    var result = false;
    
    var opts = {
        content  : '',
        title    : '',
        btnOk    : 'Đồng ý',
        btnCancel: 'Đóng',
        callback : function(result) {}
    };
    
    $.extend(opts, params);
    var html = '\
        <div class="lightbox ma20 blueColor">'
    + '<div class="lbTop"></div>'
    + '<div class="lbMid por">'
    + '<h3 class="fs24 mb20">' + opts.title + '</h3>'
    + '<div class="clear"></div>'
    + '<div class="lbContent">'
    + '<div class="lbBody">'
    + '<div class="lbLine mb20"></div>'
    + '<div class="lbMainBody"><p class="lbDescTitle fwb">' + opts.content + '</p></div>'
    + '</div>'
    + '<div class="lbFooter mt10">'
    + '<button class="uiBtn uiBtn3 fRight mr10" id="confirm_btn_no">' + opts.btnCancel + '</button>'
    + '<button class="uiBtn uiBtn1 fRight mr10" id="confirm_btn_yes">' + opts.btnOk + '</button>'
    + '<div class="clear"></div>'
    + '</div>'
    + '</div>'
    + '<div class="lbPen"></div>'
    + '</div>'
    + '<div class="lbBot"></div>'
    + '</div>';	
    
    $.colorbox({
        close: 'x',
        transition: 'none',
        scrolling: false,
        html: html,
        onClosed: function() {
            opts.callback(result);
        }
    });
    
    $('#confirm_btn_yes').click(function(e) {
        result = true;
        $.colorbox.close();
        e.preventDefault();
    });
    
    $('#confirm_btn_no').click(function(e) {
        $.colorbox.close();
        e.preventDefault();
    });

};

function URI(uri) {
    if(uri === window) return;
    if(this === window) return new URI(uri||window.location.href);
    this.parse(uri||'');
    return this;
}

function football_go_uri(uri, a) {
    uri = uri.toString();
    if(!a && window.PageTransitions && PageTransitions.isInitialized()){
        PageTransitions.go(uri);
    }
    else if(window.location.href == uri){
        window.location.reload();
    }
    else {
        window.location.href = uri;
    }
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
    },
    getPort:function(){
        return this.port;
    },
    setProtocol:function(protocol){
        this.protocol = protocol;
        return this;
    },
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
            football_go_uri(interp.redirect);
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
    },
    getPayload:function(){
        return this.payload;
    },
    getError:function(){
        return this.error;
    },
    getErrorSummary:function(){
        return this.errorSummary;
    },
    setErrorSummary:function(errorSummary){
        errorSummary = (errorSummary===undefined ? null : errorSummary);
        this.errorSummary=errorSummary;
        return this;
    },
    getErrorDescription:function(){
        return this.errorDescription;
    },
    getErrorIsWarning:function(){
        return this.errorIsWarning;
    },
    setReplay:function(isReplay){
        isReplay = (isReplay === undefined ? true : isReplay);
        this.replay=isReplay;
        return this;
    },
    isReplay:function(){
        return this.replay;
    }   
});

var Form = {
    bootstrap : function(form, actor, relative) {       
        var stat_elem = $(actor || form).parents('.stat_elem').get(0);      

        if ($.browser.msie) {
            $(':input', form).each(function() {
                var placeholder = $(this).attr('placeholder'), val = $(this).val();
                if (placeholder && placeholder === val)
                    $(this).val('');
            });
        }
        var data = Form.serialize(form, actor);         
        Form.setDisabled(form, true);

        // disable input
        relative = relative || form;
        var url = $(form).attr('ajaxify') || $(form).attr('action');
        var method = $(form).attr('method') || 'GET';
        var asyncRequest = new AsyncRequest(new URI(url));     
          
        asyncRequest.setData(data).setMethod(method).setRelativeTo(relative).setStatusElement(stat_elem).setHandler(function(asyncResponse) {
            // khi hang ve
            }).setFinallyHandler(function(asyncResponse) {
            // enable lai input
            Form.setDisabled(form, false);
        }).send();       
    },
    serialize: function(form, actor){
        var data = $(form).serializeArray();        
        if (actor && actor.name && actor.value && !actor.disabled) 
            data.push({
                name: actor.name, 
                value: actor.value
            });
        return data;                
    },
    setDisabled:function(form, state){
        $(':input', form).each(function() {
            if (this.disabled != undefined) {
                var currentState = $(this).data('origDisabledState');
                if (state) {                    
                    if (currentState == null) $(this).data('origDisabledState', this.disabled);
                    this.disabled = state;
                } else {
                    if (currentState !== true) this.disabled = false;
                    $(this).data('origDisabledState', null);
                }
            }
        });       
    }
};

Function.prototype.deferUntil = function(cond, timeLimit, lang) {
    var ret = cond();

    if (ret) {
        this(ret);
        return null;
    }

    var self = this, interval = null, time = ( + new Date());
    interval = setInterval(function() {
        ret = cond();
        if (!ret) {
            if (timeLimit && (new Date() - time) >= timeLimit) {
            // still nothing
            } else {
                return;
            }
        }

        interval && clearInterval(interval);
        self(ret);
    }, 20, lang);

    return interval;
};

function Dialog(data, noHistory) {
    if(data) {
        this._setFromModel(data, noHistory);
    }
    return this;
}

$.extend(Dialog, {
    OK:{
        name:'ok',
        label: 'Đồng ý', 
        className:'uiBtn uiBtn1 fRight mr10'
    },
    SURE : {
        name : 'sure',
        label: 'Chắc chắn',
        className:'uiBtn uiBtn1 fRight mr10'
    },
    CONFIRM : {
        name : 'confirm',
        label: 'Xác nhận',
        className:'uiBtn uiBtn1 fRight mr10'
    },
    CANCEL:{
        name:'cancel', 
        label:'Hủy bỏ', 
        className:'uiBtn12 fRight mr10'
    },
    CLOSE:{
        name:'close',
        className:'uiBtn uiBtn1 fRight mr10',
        label: 'Đóng'
    }
});

$.extend(Dialog, {
    _STANDARD_BUTTONS : [Dialog.OK,Dialog.CANCEL,Dialog.CLOSE,Dialog.SURE,Dialog.CONFIRM],
    _STACK : new Array(), 
    buildButton : function(buttons, grayLine) {
        var html = '';
        
        if (buttons && buttons.length > 0) {
            
            html+= '<div class="lbFooter mt10">';
            for (var i=buttons.length-1; i >= 0; i--) {
                var button = buttons[i];

                if (button && button.name && button.label) {
                    var className = (button.className ? 'class="'+button.className+'"' : 'class="uiBtn uiBtn1 fRight mr10"')
                    html += '<button '+className+' name="'+button.name+'">'+button.label+'</button>';
                }
            }
            html += '        <div class="clear"></div>';
            html+='</div>';
        }
        
        return html;
    },
    buildHtml : function(title, body, buttons, type, className) {
        var html = '';
        if (type == 'alert') {
            html += '<div>';
            html += '    <div class="lightbox ma20 blueColor">';
            html += '       <div class="lbTop"></div>';
            html += '       <div class="lbMid por">';
            if (title) {
                html += '       <h3 class="fs24 mb20">'+title+'</h3>';
                html += '        <div class="clear"></div>';
            }
            html += '           <div class="lbContent">';
            html += '                <div class="lbBody">';
            html += '                   <div class="lbLine mb20"></div>';
            html += '                   <div class="lbMainBody"><p class="lbDescTitle fwb">';
            if (body) html+= body;
            html += '                   </p></div>';
            html += '                </div>';
            
            html += Dialog.buildButton(buttons, true);
            
            html += '           </div>';                
            html += '           <div class="lbPen"></div>';                
            html += '       </div>';
            html += '        <div class="lbBot"></div>';                
            html += '   </div>';    
            html += '</div>';    
        } else if (type == 'loading') {
        // Rem l?i d? s? d?ng loading default c?a colorbox
        /*
            html += '<div>';
            html += '<div class="lightbox" id="loading-data">';
            html += '<div class="lightbox-loading rounded-lb">�ang t?i d? li?u</div>';
            html += '</div></div>';
            */
        } else if (type == 'share') {
            html += '<div>';
            html += '   <div class="lightbox ma20 blueColor">';
            html += '       <div class="lbTop"></div>';
            html += '       <div class="lbMid por">';
            if (title) {
                html += '       <h3 class="fs24 mb20">'+title+'</h3>';
                html += '       <div class="clear"></div>';
            }
            html += '           <div class="lbContent">';
            if (body) html +=       body;
            html += '           </div><div class="lbPen"></div>';                
            html += '       </div>';
            html += '        <div class="lbBot"></div>';                
            html += '   </div>';    
            html += '</div>';

        } else if(type == 'stream_detail'){
            html += body;
        } else {
            className = className ? className : "lightbox";
            html += '<div>';
            html += '   <div class="'+className+' ma20 blueColor">';
            html += '       <div class="lbTop"></div>';
            html += '       <div class="lbMid por">';
            if (title) {
                html += '       <h3 class="fs24 mb20">'+title+'</h3>';
                html += '       <div class="clear"></div>';
            }
            html += '           <div class="lbContent">';
            html += '                <div class="lbBody">';
            html += '                   <div class="lbLine mb20"></div>';
            html += '                   <div class="lbMainBody"><p class="lbDescTitle fwb">';
            if (body) html += body;
            html += '                   </p></div>';
            html += '                </div>';
            
            html += Dialog.buildButton(buttons, true);
            
            html += '           </div>';                
            html += '           <div class="lbPen"></div>';                
            html += '       </div>';
            html += '        <div class="lbBot"></div>';                
            html += '   </div>';    
            html += '</div>';    
        }
        
        return html;
    },
    
    _findButton:function(name, buttons){
        if(buttons) {
            for(var i=0; i < buttons.length; ++i) {
                if(buttons[i] && buttons[i].name == name) return buttons[i];
            }
        }
        return null;
    },
    bootstrap : function(uri, data, is_get, method, option, obj)  {
        try{
            data = data || {};
            
            uri = new URI(uri);

            $.extend(data, uri.getQueryData());
            
            method = method || (is_get ? 'GET' : 'POST');

            if (method == 'POST') {
                uri.setQueryData({});
            }
            
            var stat_elem = $(obj).parents('.stat_elem').get(0) || obj;
                    
            if (stat_elem && $(stat_elem).hasClass('loading-ajax')) return false;
            
            var request = new AsyncRequest().setMethod(method).setRelativeTo(obj).setStatusElement(stat_elem);
            
            var dialog = new Dialog(option).setRelativeTo(obj).setAsync(request.setURI(uri).setData(data));
            
            dialog.show();
        }catch(e) { }
        return false;
    }
});

$.extend( Dialog.prototype, {
    _handler : null,
    _clicked_button : null,
    _relativeTo : null,
    _showHadnler: null,
    setPostURI:function(uri, showDialog) {
        // b, a 
        if(showDialog===undefined) showDialog=true;
    
       
        var _this = this;
        this.setHandler(function() {
            _this._submitForm('POST', uri, false, showDialog);
        });
       
        return this;
    },
    setHandler:function(handler) {
        this._handler = handler;
        return this;
    },
    _submitForm:function(method, uri, button, showDialog) {
        var data = this.getFormData();
        
        if(button) data[button.name] = button.label;
        
        var request = new AsyncRequest().setURI(new URI(uri)).setData(data).setMethod(method).setRelativeTo(this._relativeTo);
        
        if (showDialog) {
            this.setAsync(request);
            this.show();    
        } else request.send();
        
        this.show();
        
        return false;
    },
    getFormData:function() {
        return $('#cboxLoadedContent *').serializeArray();
    },
    setCancelHandler:function(handler){
        this._cancelHandler = handler;
        return this;
    },
    setShowHandler:function(handler) {
        this._showHadnler = handler;
        return this;
    },
    setCloseHandler:function(a){
        this._close_handler=Dialog.call_or_eval.bind(null,this,a);
        return this;
    },
    show : function() {
        if (this._async_request != null) 
        {
            $.colorbox({
                html: Dialog.buildHtml(null, null, null, 'loading'),
                transition: "none",
                needLoading: false
            });
        } else this._update();
    },
    setAsync:function(request, f) {
        var data = request.getData(), _this = this;
        data.__d=1;
        request.setData(data); 
        
        this._async_request = request;
        
        // dat su kien sau khi request xong 
        request.setHandler(function(response) {
            if(_this._async_request != request) return;
            
            _this._async_request = null;
            
            var payload = response.getPayload();
            
            if (typeof payload == 'string') {
                _this.body = payload;
            } else if (payload && payload.__dialog) 
                _this._setFromModel(payload.__dialog);
            else {
                $.colorbox.close();
                return;
            }
            
            _this._update();
        });        
        
        //e.setErrorHandler(chain(d,e.getErrorHandler())).setTransportErrorHandler(chain(d,e.getTransportErrorHandler()));
        request.send();
       
        
        return this;
    },
    _update : function() {
        var _this = this;
        $.colorbox({
            html: Dialog.buildHtml(_this.title, _this.body, _this.buttons, _this.type, _this.className),
            transition: "none",
            needLoading: false,
            onComplete: function() {
                _this._onComplete()
            },
            onClosed : function() {
                Dialog._STACK = Array();
            }
        });
    },
    _onComplete : function() {
        var container = $('#cboxLoadedContent'), _this = this;
        if (this._showHadnler) {
            this._showHadnler();
        }
        
        $('button', container).click(function() {
            if ( this.name == 'cancel') {
                $.colorbox.close();
                if (_this._cancelHandler) _this._cancelHandler();
            } else if (_this._handler) {
                _this._handler();
                _this._handler = null;
            }
            
            if (_this._async_request  == null) {
                if (_this.storeHistory || _this.goHistory)
                {
                    if (_this.goHistory)
                    {
                        for (var i=0; i < _this.goHistory; i++)
                            Dialog._STACK.pop();
                    } else if (_this.storeHistory) {
                        Dialog._STACK.pop();
                    }
                    
                
                    if (Dialog._STACK.length > 0) {
                        _this._setFromModel(Dialog._STACK.pop());
                        _this._update();
                        return;
                    } 
                }
                $.colorbox.close();
            }
        });
    },
    _setFromModel:function(payload) {
        this.storeHistory = null;
        this.goHistory = null;
        this.body = null;
        this.title = null;
        this.buttons = null;
        this.type = null;
        this.className = null;
        this.postURI = null;
        this._handler = null;
        this._cancelHandler = null; 
        
        // luu vao stack
        if (payload.storeHistory) {
            Dialog._STACK.push(payload);
        }
            
        
        for (prop in payload) {
            var method = this['set' + prop.substr(0,1).toUpperCase() + prop.substr(1)];
            var args = new Array();
            
            if (typeof payload[prop] == 'object') {
                for (var i=0; i < payload[prop].length; i++)
                    args.push(payload[prop][i]);
            } else args.push(payload[prop]);
            
            if(method) method.apply(this, args);
        }
    },
    setGoHistory : function(goHistory) {
        this.goHistory = goHistory;
    }
    ,
    setStoreHistory : function(storeHistory) {
        this.storeHistory = storeHistory;
    },
    setBody : function(body) {
        this.body = body;
    }, 
    setTitle: function(title) {
        this.title = title;
    },
    setButtons: function(buttons) {
        this.buttons = [];
        for (var i=0; i < arguments.length; i++) {
            var button = arguments[i];
            
            if(typeof button =='string'){
                button = Dialog._findButton(arguments[i], Dialog._STANDARD_BUTTONS);        
            }
            this.buttons[i] = button; 
        }
    
        return this;
    },
    setType: function(type) {
        this.type = type;
    },
    setClassName: function(className) {
        this.className = className;
    },
    setRelativeTo : function(relativeTo) {
        this._relativeTo = relativeTo;
        return this;
    }
});


$('a, button, area').live('click', function(e) {    
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

var last_submit_button = null;

$(":submit").live('click', function() {
    last_submit_button = this;
});

$('form').live('submit', function(e) {              
    var url = $(this).attr('action');
    var rel = $(this).attr('rel');      
    var method = $(this).attr('method');

    switch (rel) {
        case 'async':
            Form.bootstrap(this, last_submit_button);
            break; 
        default:
            return;
    }

    last_submit_button = null;
    e.preventDefault();
});
