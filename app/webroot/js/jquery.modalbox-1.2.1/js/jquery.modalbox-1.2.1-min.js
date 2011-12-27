/*
* jQuery modalBox plugin v1.2.1 <http://code.google.com/p/jquery-modalbox-plugin/>
* @requires jQuery v1.3.2 or later 
* is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
(function(c){var d={minimalTopSpacingOfModalbox:50,draggable:true,killModalboxWithCloseButtonOnly:false,setWidthOfModalLayer:null,customClassName:null,getStaticContentFrom:null,positionLeft:null,positionTop:null,effectType_show_fadingLayer:["fade","fast"],effectType_hide_fadingLayer:["fade","fast"],effectType_show_modalBox:["show"],effectType_hide_modalBox:["hide"],selectorModalboxContainer:"#modalBox",selectorModalboxBodyContainer:"#modalBoxBody",selectorModalboxBodyContentContainer:".modalBoxBodyContent",selectorFadingLayer:"#modalBoxFaderLayer",selectorAjaxLoader:"#modalBoxAjaxLoader",selectorModalboxCloseContainer:"#modalBoxCloseButton",selectorModalboxContentContainer:".modalboxContent",selectorHiddenAjaxInputField:"ajaxhref",selectorPreCacheContainer:"#modalboxPreCacheContainer",selectorImageGallery:".modalgallery",setModalboxLayoutContainer_Begin:'<div class="modalboxStyleContainer_surface_left"><div class="modalboxStyleContainer_surface_right"><div class="modalboxStyleContainerContent"><div class="modalBoxBodyContent">',setModalboxLayoutContainer_End:'</div></div></div></div><div class="modalboxStyleContainer_corner_topLeft"><!-- - --></div><div class="modalboxStyleContainer_corner_topRight"><!-- - --></div><div class="modalboxStyleContainer_corner_bottomLeft"><!-- - --></div><div class="modalboxStyleContainer_corner_bottomRight"><!-- - --></div><div class="modalboxStyleContainer_surface_top"><div class="modalboxStyleContainer_surface_body"><!-- - --></div></div><div class="modalboxStyleContainer_surface_bottom"><div class="modalboxStyleContainer_surface_body"><!-- - --></div></div>',localizedStrings:{messageCloseWindow:"Close Window",messageAjaxLoader:"Please wait",errorMessageIfNoDataAvailable:"<strong>No content available!</strong>",errorMessageXMLHttpRequest:'Error: XML-Http-Request Status "500"',errorMessageTextStatusError:"Error: AJAX Request failed"},setTypeOfFadingLayer:"black",setStylesOfFadingLayer:{white:"background-color:#fff; filter:alpha(opacity=60); -moz-opacity:0.6; opacity:0.6;",black:"background-color:#000; filter:alpha(opacity=40); -moz-opacity:0.4; opacity:0.4;",transparent:"background-color:transparent;",custom:null},directCall:{source:null,data:null,element:null},ajax_type:"POST",ajax_contentType:"application/x-www-form-urlencoded; charset=utf-8",callFunctionBeforeShow:function(){return true;},callFunctionAfterShow:function(){},callFunctionBeforeHide:function(){},callFunctionAfterHide:function(){}};try{d=jQuery.extend({},d,modalboxGlobalDefaults);}catch(b){}var a={init:function(j){var j=jQuery.extend({},d,j);if(j.directCall){if(j.directCall["source"]){g({type:"ajax",source:j.directCall["source"],data:null});}else{if(j.directCall["data"]){g({type:"static",source:null,data:j.directCall["data"]});}else{if(j.directCall["element"]){g({type:"static",source:null,data:jQuery(j.directCall["element"]).html()});}}}}var k=false;jQuery(window).resize(function(){k=true;});if(!k){jQuery(this).die("click").live("click",function(m){h({event:m,element:jQuery(this)});});}function h(p){var p=jQuery.extend({event:null,element:null,doNotOpenModalBoxContent:false,isFormSubmit:false},p||{});if(p.event&&p.element){var m=p.element;if(m.is("input")){var r=m.parents("form").attr("action");var q=m.parents("form").serialize();var o="ajax";p.isFormSubmit=true;p.event.preventDefault();}else{if(jQuery("input[name$='"+j.selectorHiddenAjaxInputField+"']",m).length!=0){var r=jQuery("input[name$='"+j.selectorHiddenAjaxInputField+"']",m).val();var q="";var o="ajax";p.event.preventDefault();}else{if(jQuery(j.selectorModalboxContentContainer,m).length!=0){if(jQuery(j.selectorModalboxContentContainer+" img"+j.selectorImageGallery,m).length!=0){var n=jQuery(j.selectorModalboxContentContainer+" img"+j.selectorImageGallery,m);}var r="";var q=jQuery(j.selectorModalboxContentContainer,m).html();var o="static";p.event.preventDefault();}else{if(j.getStaticContentFrom){var r="";var q=jQuery(j.getStaticContentFrom).html();var o="static";p.event.preventDefault();}else{p.doNotOpenModalBoxContent=true;}}}}if(!p.doNotOpenModalBoxContent){g({type:o,element:m,source:r,data:q,loadingImagePreparer:{currentImageObj:n,finalizeModalBox:false}});}if(p.isFormSubmit){return false;}}}function e(n){var n=jQuery.extend({ar_XMLHttpRequest:null,ar_textStatus:null,ar_errorThrown:null,targetContainer:null,ar_enableDebugging:false},n||{});var o=n.ar_XMLHttpRequest;var r=n.ar_textStatus;var p=n.ar_errorThrown;if(o&&r!="error"){if(o.status==403){var q=o.getResponseHeader("Location");if(typeof q!=="undefined"){location.href=q;}}else{if(o.status==500&&n.targetContainer){m({errorMessage:j.localizedStrings["errorMessageXMLHttpRequest"],targetContainer:n.targetContainer});}}if(n.ar_enableDebugging){console.log("XMLHttpRequest.status: "+o.status);}}else{if(r=="error"){if(n.targetContainer){m({errorMessage:j.localizedStrings["errorMessageTextStatusError"],targetContainer:n.targetContainer});}if(n.ar_enableDebugging){console.log("textStatus: "+r);}}else{}}function m(s){var s=jQuery.extend({errorMessage:null,targetContainer:null},s||{});if(s.errorMessage&&s.targetContainer){var t='<div class="simleModalboxErrorBox"><div class="simleModalboxErrorBoxContent">'+s.errorMessage+"</div></div>";jQuery(s.targetContainer).removeAttr("style").html(t);if(jQuery(s.targetContainer).parents(j.selectorModalboxContainer).length>0){jQuery(j.selectorAjaxLoader).remove();i();}}}}function f(m){var m=jQuery.extend({type:m.type,element:m.element,source:m.source,data:m.data,loadingImagePreparer:{currentImageObj:m.loadingImagePreparer["currentImageObj"],finalizeModalBox:m.loadingImagePreparer["finalizeModalBox"]},nameOfImagePreloaderContainer:"imagePreparerLoader",wrapContainer:'<div class="modalBoxCarouselItemContainer"></div>'},m||{});var n=m.loadingImagePreparer["currentImageObj"];if(n){jQuery(j.selectorModalboxContentContainer).css({display:"block",position:"absolute",left:"-9999px",top:"-9999px"}).removeAttr("style");g({type:m.type,element:m.element,source:m.source,data:m.data,loadingImagePreparer:{currentImageObj:n,finalizeModalBox:true,nameOfImagePreloaderContainer:m.nameOfImagePreloaderContainer}});}}function g(n){var n=jQuery.extend({type:null,element:null,source:null,data:null,loadingImagePreparer:{currentImageObj:null,finalizeModalBox:false,nameOfImagePreloaderContainer:null},prepareCustomWidthOfModalBox:"",setModalboxClassName:""},n||{});function o(){a.close({callFunctionBeforeHide:j.callFunctionBeforeHide,callFunctionAfterHide:j.callFunctionAfterHide});}if(!j.killModalboxWithCloseButtonOnly){jQuery(j.selectorFadingLayer).die("click").live("click",function(){o();});}jQuery(j.selectorModalboxContainer+" .closeModalBox").die("click").live("click",function(){o();});jQuery(j.selectorPreCacheContainer).remove();if(n.loadingImagePreparer["currentImageObj"]&&!n.loadingImagePreparer["finalizeModalBox"]){f({type:n.type,element:n.element,source:n.source,data:n.data,loadingImagePreparer:n.loadingImagePreparer});}else{if(n.type&&j.callFunctionBeforeShow()){if(n.source){n.source=a.addAjaxUrlParameter({currentURL:n.source});}if(n.element){if(jQuery(n.element).hasClass("large")){n.setModalboxClassName+="large";}else{if(jQuery(n.element).hasClass("medium")){n.setModalboxClassName+="medium";}else{if(jQuery(n.element).hasClass("small")){n.setModalboxClassName+="small";}else{if(n.loadingImagePreparer["nameOfImagePreloaderContainer"]){n.setModalboxClassName+="auto modalBoxBodyContentImageContainer";}}}}if(jQuery(n.element).hasClass("emphasis")){n.setModalboxClassName+=" emphasis";}}if(j.customClassName){n.setModalboxClassName+=" "+j.customClassName;}if(j.draggable){n.setModalboxClassName+=" modalboxIsDraggable";}if(j.setWidthOfModalLayer){n.prepareCustomWidthOfModalBox+="width:"+parseInt(j.setWidthOfModalLayer)+"px; ";}if(jQuery(j.selectorModalboxContainer).length==0){jQuery("body").append(a.modalboxBuilder({customStyles:'class="'+n.setModalboxClassName+'" style="'+n.prepareCustomWidthOfModalBox+'"'}));}else{a.clean();}var m=function(){switch(n.type){case"static":jQuery(j.selectorAjaxLoader).hide();jQuery(j.selectorModalboxBodyContentContainer,j.selectorModalboxContainer).html(n.data);i({callFunctionAfterShow:j.callFunctionAfterShow});break;case"ajax":jQuery.ajax({type:j.ajax_type,url:n.source,data:n.data,contentType:j.ajax_contentType,success:function(p,q){jQuery(j.selectorAjaxLoader).fadeOut("fast",function(){jQuery(j.selectorModalboxBodyContentContainer,j.selectorModalboxContainer).html(p);i({callFunctionAfterShow:j.callFunctionAfterShow});});},error:function(p,r,q){e({ar_XMLHttpRequest:p,ar_textStatus:r,ar_errorThrown:q,targetContainer:j.selectorModalboxContainer+" "+j.selectorModalboxBodyContentContainer});}});break;}if(j.draggable){a.dragBox();}};l({callFunctionAfterShow:m});}}}function l(n){var n=jQuery.extend({isResized:false,callFunctionAfterShow:null},n||{});if(jQuery(j.selectorFadingLayer).length==0){if(j.setTypeOfFadingLayer=="white"){var m=j.setStylesOfFadingLayer["white"];}else{if(j.setTypeOfFadingLayer=="black"){var m=j.setStylesOfFadingLayer["black"];}else{if(j.setTypeOfFadingLayer=="custom"&&j.setStylesOfFadingLayer["custom"]){var m=j.setStylesOfFadingLayer["custom"];}else{var m=j.setStylesOfFadingLayer["transparent"];}}}var p=a.cleanupSelectorName({replaceValue:j.selectorFadingLayer});jQuery("body").append('<div id="'+p+'" style="'+m+'"></div>');var o=jQuery(j.selectorFadingLayer);if(j.setTypeOfFadingLayer=="disable"){j.effectType_show_fadingLayer[0]="";}switch(j.effectType_show_fadingLayer[0]){case"fade":o.fadeIn(j.effectType_show_fadingLayer[1],function(){i({isResized:n.isResized,callFunctionAfterShow:n.callFunctionAfterShow});});break;default:o.show();i({isResized:n.isResized,callFunctionAfterShow:n.callFunctionAfterShow});break;}jQuery(window).resize(function(){if(o.is(":visible")){i({isResized:true});}});}else{i({isResized:n.isResized,callFunctionAfterShow:n.callFunctionAfterShow});}}function i(o){var o=jQuery.extend({isResized:false,callFunctionAfterShow:null},o||{});var m=jQuery(j.selectorModalboxContainer);if(jQuery(j.selectorPreCacheContainer).length==0&&m.length!=0){if(jQuery("body a.modalBoxTopLink").length==0){jQuery("body").prepend('<a class="modalBoxTopLink"></a>');}var n=false;var s="absolute";var q=0;var r=m.width();var p=m.height();var u=parseInt(jQuery(window).width()-r)/2;if(u<=0){u=0;}if(j.positionLeft){u=j.positionLeft+"px";}else{u=u+"px";}if(j.positionTop){q=parseInt(jQuery(window).height()-p);if(q>parseInt(j.positionTop)){s="fixed";}q=j.positionTop+"px";}else{q=parseInt(jQuery(window).height()-p-70)/2;if(q<=0){q=j.minimalTopSpacingOfModalbox+"px";n=true;}else{q=q+"px";s="fixed";}}function t(){if(n&&!m.hasClass("modalboxScrollingSuccessfully")){m.addClass("modalboxScrollingSuccessfully");a.scrollTo();}if(!o.isResized){if(o.callFunctionAfterShow){o.callFunctionAfterShow();}}}switch(j.effectType_show_modalBox[0]){case"fade":if(m.hasClass("modalboxFadingSuccessfully")){m.css({position:s,left:u,top:q,display:"block",visibility:"visible"});t();}else{m.css({position:s,left:u,top:q,visibility:"visible"}).fadeIn(j.effectType_show_modalBox[1],function(){jQuery(this).addClass("modalboxFadingSuccessfully");t();});}break;default:m.css({position:s,left:u,top:q,display:"block",visibility:"visible"});t();break;}}}},close:function(e){var e=jQuery.extend({},d,e);if(e.selectorFadingLayer&&e.selectorModalboxContainer){e.callFunctionBeforeHide();var g=jQuery(e.selectorFadingLayer+", "+e.selectorModalboxContainer);if(e.setTypeOfFadingLayer=="disable"){e.effectType_hide_fadingLayer[0]="";}switch(e.effectType_hide_fadingLayer[0]){case"fade":switch(e.effectType_hide_modalBox[0]){case"fade":jQuery(e.selectorModalboxContainer).fadeOut(e.effectType_hide_modalBox[1],function(){jQuery(e.selectorFadingLayer).fadeOut(e.effectType_hide_fadingLayer[1],function(){f(g);});});break;default:jQuery(e.selectorModalboxContainer).hide();jQuery(e.selectorFadingLayer).fadeOut(e.effectType_hide_fadingLayer[1],function(){f(g);});break;}break;default:switch(e.effectType_hide_modalBox[0]){case"fade":jQuery(e.selectorModalboxContainer).fadeOut(e.effectType_hide_modalBox[1],function(){f(g);});break;default:f(g);break;}break;}}function f(h){h.remove();e.callFunctionAfterHide();}},clean:function(e){var e=jQuery.extend({},d,e);if(e.selectorModalboxBodyContentContainer){var f=a.cleanupSelectorName({replaceValue:e.selectorAjaxLoader});jQuery(e.selectorModalboxBodyContentContainer).html('<div id="'+f+'">'+e.localizedStrings["messageAjaxLoader"]+"</div>");}},scrollTo:function(f){var f=jQuery.extend({targetElement:"a.modalBoxTopLink",typeOfAnimation:"swing",animationSpeed:800,callAfterSuccess:function(){}},f||{});if(f.targetElement){if(jQuery.browser.webkit){var e=jQuery("body");}else{var e=jQuery("html");}e.animate({scrollTop:jQuery(f.targetElement).offset().top},f.animationSpeed,f.typeOfAnimation,function(){f.callAfterSuccess();});}},cleanupSelectorName:function(e){var e=jQuery.extend({replaceValue:""},e||{});var f=e.replaceValue;f=f.replace(/[#]/g,"");f=f.replace(/[.]/g,"");return f;},dragBox:function(f){var f=jQuery.extend({dragObject:null,dragObjectPosX:0,dragObjectPosY:0,documentPosX:0,documentPosY:0},f||{});f=jQuery.extend({},d,f);function e(g){f.dragObject=g;f.dragObjectPosX=(f.documentPosX-f.dragObject.offsetLeft);f.dragObjectPosY=(f.documentPosY-f.dragObject.offsetTop);}jQuery(document).mousemove(function(g){f.documentPosX=g.pageX;f.documentPosY=g.pageY;if(f.dragObject){jQuery(f.dragObject).css({left:(f.documentPosX-f.dragObjectPosX)+"px",top:(f.documentPosY-f.dragObjectPosY)+"px"});}});jQuery(f.selectorModalboxContainer+" .modalboxStyleContainer_surface_top, "+f.selectorModalboxContainer+" .modalboxStyleContainer_surface_bottom").unbind("mousedown").bind("mousedown",function(g){if(g.type=="mousedown"){jQuery(f.selectorModalboxContainer).unbind("mousemove mouseup").bind("mousemove mouseup",function(h){var i=jQuery(this);if(i.is(":visible")){if(h.type=="mousemove"){e(this);}else{if(h.type=="mouseup"){f.dragObject=null;i.unbind("mousemove");}}}});}});},addAjaxUrlParameter:function(e){var e=jQuery.extend({currentURL:"",addParameterName:"ajaxContent",addParameterValue:"true"},e||{});var g=e.currentURL;if(g.indexOf(e.addParameterName)!=-1){g=g;}else{if(g.indexOf("?")!=-1){var f="&";}else{var f="?";}g=g+f+e.addParameterName+"="+e.addParameterValue;}return g;},precache:function(e){var e=jQuery.extend({},d,e);if(e.selectorPreCacheContainer){if(jQuery(e.selectorPreCacheContainer).length==0){var h=a.cleanupSelectorName({replaceValue:e.selectorPreCacheContainer});var g=a.modalboxBuilder();var f="";f+='<div id="'+h+'" style="position:absolute; left:-9999px; top:-9999px;">';f+=g;f+="</div>";jQuery("body").append(f);jQuery(e.selectorModalboxContainer).show();}}},modalboxBuilder:function(h){var h=jQuery.extend({customStyles:""},h||{});h=jQuery.extend({},d,h);var g=a.cleanupSelectorName({replaceValue:h.selectorModalboxContainer});var f=a.cleanupSelectorName({replaceValue:h.selectorModalboxBodyContainer});var k=a.cleanupSelectorName({replaceValue:h.selectorModalboxBodyContentContainer});var e=a.cleanupSelectorName({replaceValue:h.selectorModalboxCloseContainer});var j=a.cleanupSelectorName({replaceValue:h.selectorAjaxLoader});var i="";i+='<div id="'+g+'"'+h.customStyles+">";i+='<div id="'+f+'">';i+=h.setModalboxLayoutContainer_Begin;i+='<div class="'+k+'">';i+='<div id="'+j+'">'+h.localizedStrings["messageAjaxLoader"]+"</div>";i+="</div>";i+=h.setModalboxLayoutContainer_End;i+='<div id="'+e+'"><a href="javascript:void(0);" class="closeModalBox"><span class="closeModalBox">'+h.localizedStrings["messageCloseWindow"]+"</span></a></div>";i+="</div>";i+="</div>";return i;}};jQuery.fn.modalBox=function(e){if(a[e]){return a[e].apply(this,Array.prototype.slice.call(arguments,1));}else{if(typeof e==="object"||!e){return a.init.apply(this,arguments);}else{jQuery.error("Method "+e+" does not exist on jQuery.modalBox");}}};jQuery(document).ready(function(){jQuery.fn.modalBox("precache");jQuery(".openmodalbox").modalBox();});})(jQuery);