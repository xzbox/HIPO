/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                       Created by AliReza Ghadimi                          *
 *     <http://AliRezaGhadimi.ir>    LO-VE    <AliRezaGhadimy@Gmail.com>     *
 *****************************************************************************/
var forms       = Object();
forms.data      = {};
forms.dLength   = 0;
forms.reads     = 0;
forms.name      = '';
forms.send      = function(){
    api.sendCommand('forms',{
        name:forms.name,
        data:forms.data
    });
};
/**
 * @param el
 * @returns {Object}
 */
forms.readFile  = function(el){
    var reader = new FileReader();
    var blob      = el.files[0];
    var name      = $(el).attr('name');
    reader.onloadend    = function(){
        forms.data[name]= btoa(reader.result);
        forms.dLength--;
        if(forms.dLength == 0){
            forms.send();
        }
    };
    if(blob){
        reader.readAsBinaryString(blob);
    }else {
        forms.dLength--;
    }
};
/**s
 * Manage submits of all of forms
 * @param form
 */
forms.onSubmit  = function(form){
    form        = $(this);
    forms.name = form.data('name');
    form.find('input').each(function(){
        var el = $(this);
        if(el.attr('type') == 'file'){
            forms.dLength++;
            forms.readFile(this);
        }else {
            forms.data[el.attr('name')] = btoa(el.val());
        }
    });
    if(forms.dLength == 0){
        forms.send();
    }
    form[0].reset();
    return false;
};
forms.load      = function(){
    $('form').each(function(form){
        form = $(this);
        if(form.data('name') != undefined){
            form.submit(forms.onSubmit);
        }
    });
};
var template    = Object();
template.vue= new Vue({
    el: '#app',
    replace: false,
    data: {}
});
/**
 * @type Object
 */
template.events = Object();
/**
 *
 * @param event
 * @param pageName
 */
template.pageLoad   = function (event,pageName){
    if(pageName === undefined){
        pageName = api.pageName;
    }
    var event_name = 'PHPSocket_load_'+pageName;
    if(template.events[event_name] === undefined || template.events[event_name].toString() !== event.toString()){
        console.log('asa');
        $(document).on(event_name,event);
        template.events[event_name] = event;
    }
};
/**
 *
 * @param name
 * @param value
 */
template.set    = function(name,value){
    return template.vue.$set(name,value);
};
/**
 *
 * @param name
 */
template.get    = function(name){
    return template.vue.$get(name);
};
/**
 *
 * @param tem
 */
template.load   = function(tem){
    /**
     * Insert template first with jQuery so it runs javascript
     */
    var app = $('#app').slideUp(500).html(tem);
    template.vue= new Vue({
        el: '#app',
        //template: tem,
        replace: false,
        data: {}
    });
    iDb.vue();
    forms.load();
    app.slideDown();
    var event_name = 'PHPSocket_load_'+api.pageName;
    $(document).trigger(event_name)
};
template.set    = function(name,value){
    template.vue.$set(name.replace('template_page_pages\\','pages.'),value);
};
template.incReg = new  RegExp('{{inc\\s+?(\\S+?)}}');
template.make   = function (name){
    if(iDb.isset('template_page_pages\\'+name)){
        var tem = iDb.get('template_page_pages\\'+name);
        var inc;
        while(template.incReg.test(tem)){
            inc = template.incReg.exec(tem);
            tem = tem.replace(inc[0],iDb.get('template_page_pages\\'+inc[1]));
        }
        return tem;
    }else {
        return '';
    }
};