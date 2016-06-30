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
var sidebar = new Vue({el:"#aside",replace:!1,data:{
    name:"مهمان",
    page_name:"main"
}});
function wrong_login(){
    template.vue.$set('wrong_login',true);
}
function right_login(){
    iDb.set('is_login',1);
    sidebar.$set('is_login',1);
    sidebar.$set('name',iDb.get('u.'+iDb.get('current_username')+'.fname'));
    api.open('main');
    $('#head_btn').attr('href','#logout').text('خروج');
}
function signup_wrong_email(){
    template.vue.$set('wrong_email',true);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',false);
}
function signup_used_username(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',true);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',false);
}
function signup_same_repass(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',true);
    template.vue.$set('wrong_age',false);
}
function signup_wrong_age(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',true);
}
function signup_success(){
    template.vue.$set('wrong_email',false);
    template.vue.$set('used_username',false);
    template.vue.$set('wrong_pass',false);
    template.vue.$set('wrong_age',false);
    template.vue.$set('signup_success',true);
    setTimeout('api.open("main")',500);
}
function logout(){
    iDb.set('is_login',0);
    sidebar.$set('is_login',0);
    api.open('login');
    $('#head_btn').attr('href','#login').text('ورود');
    sidebar.$set('name','مهمان');
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