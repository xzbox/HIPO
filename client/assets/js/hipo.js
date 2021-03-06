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
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/
var sidebar = new Vue({el:"#header",replace:false,data:{
    name:lng('guest'),
    page_name:"main",
    role:'',
    head_btn:lng('login'),
    head_btn_href:'#login'
}});
function createMenu(obj){
    var re = '';
    for(var key in obj){
        var val = obj[key];
        if(typeof(val.val) == 'object'){
            re += '<li class="sub-menu">'+
                '<a href="javascript:;"><i class="fa fa-'+val.icon+'"></i> <span>'+val.text+'</span></a>'+
                '<ul class="sub">';
            for(var k in val.val){
                console.log(val.val[k]);
                var v = val.val[k];
                re += '<li class="{{(page_name == \''+v.page+'\') ? \'active\' : \'\'}}">'+
                    '<a href="#'+v.page+'">'+ v.val+'</a></li>';
            }
            re += '</ul></li>';
        }else{
            re += '<li class="mt ">'+
                '<a href="#'+val.page+'" class="{{(page_name == \''+val.page+'\') ? \'active\' : \'\'}}">'+
                '<i class="fa fa-'+val.icon+'"></i> '+
                '<span>'+val.val+'</span>'+
                '</a>'+
                '</li>';
        }
    }
    return re;
}
function adminMenu(){
    sidebar.$set('role','admin');
}
function adminUser(){
    sidebar.$set('role','user');
}
function wrong_login(){
    template.vue.$set('wrong_login',true);
}
function right_login(role){
    iDb.set('role',role);
    sidebar.$set('role',role);
    iDb.set('is_login',1);
    sidebar.$set('is_login',1);
    sidebar.$set('name',iDb.get('u.'+iDb.get('current_username')+'.fname'));
    sidebar.$set('head_btn',lng('logout'));
    sidebar.$set('head_btn_logout','#logout');
}
function turnOffErrors(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',false);
    template.vue.$set('wrong_fname',false);
    template.vue.$set('wrong_lname',false);
    template.vue.$set('wrong_username',false);
}
function signup_wrong_email(){
    turnOffErrors();
    template.vue.$set('wrong_email',true);
}
function signup_used_username(){
    turnOffErrors();
    template.vue.$set('used_username',true);
}
function signup_same_repass(){
    turnOffErrors();
    template.vue.$set('wrong_pass',true);
}
function signup_wrong_age(){
    turnOffErrors();
    template.vue.$set('wrong_age',true);
}
function signup_wrong_fname(){
    turnOffErrors();
    template.vue.$set('wrong_fname',true);
}
function signup_wrong_lname(){
    turnOffErrors();
    template.vue.$set('wrong_lname',true);
}
function signup_wrong_username(){
    turnOffErrors();
    template.vue.$set('wrong_username',true);
}

function signup_success(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',false);
    template.vue.$set('signup_success',true);
    setTimeout('api.open("main")',500);
}
function getRank(username){
    var users   = iDb.keys('u.\\w+.score',0,false);
    var scores  = [];
    for(var i = 0;i < users.length;i++){
        scores[i]   = parseInt(iDb.get(users[i]));
    }
    scores.sort(function(a,b){
        return a-b;
    });
    var score   = parseInt(iDb.get('u.'+username+'.score'));
    var b       = 0XFFFFF;
    var re      = 1;
    for(i = 0;i < scores.length;i++){
        if(scores[i] == score){
            return re;
        }
        if(scores[i] !== b){
            re++;
        }
        b   = scores[i];
    }
}
var hipo    = Object();
logout = function(){
    iDb.set('is_login',0);
    sidebar.$set('is_login',0);
    sidebar.$set('head_btn',lng('login'));
    sidebar.$set('head_btn_logout','#login');
    sidebar.$set('name',lng('guest'));
    sidebar.$set('role','guest');
};