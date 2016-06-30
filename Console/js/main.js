/***
 *       ____      ________    _____  _____     _____
 *      / __ \    (___  ___)  (_   _) )__  \   / ___/
 *     / /  \ \       ) )       | |    __) /  ( (__
 *    ( (    ) )     ( (        | |   (__ (    ) __)
 *    ( (  /\) )      ) )       | |      \ \  ( (
 *     \ \_\ \/      ( (       _| |__ ___/  )  \ \___
 *      \___\ \_     /__\     /_____( )____/    \____\
 *           \__)
 */
var gTerm;
$(function() {
  $('.j-tooltip').tooltip();
  var prompt = "[[b;#d33682;]root]@[[b;#6c71c4;]PHPSocket] ~$ ";
    function print_slowly(term, paragraph, callback) {
      var foo, i, lines;
      lines = paragraph.split("\n");
      term.pause();
      i = 0;
      foo = function(lines) {
        return setTimeout((function() {
          if (i < lines.length -1) {
            term.echo(lines[i]);
            i++;
            return foo(lines);
          } else {
            term.resume();
            return callback();
          }
        }), 1000);
      };
      return foo(lines);
    }
  var ws;
  var encryptionSocket = function(webSocket){
    var obj = Object();
    obj.onmessage = webSocket.onmessage;
    obj.send = function(msg){
      //TODO:Encrypt Data to send with RSA
      webSocket.send(msg);
    };
    webSocket.onmessage = function(msg){
      //TODO:Decrypt Received Message with RSA
      msg = msg.data;

      obj.onmessage(msg);
    };
    return obj;
  };
  var isConnect = false;
  function connect(host,port){
    gTerm.echo('Connecting to '+host+':'+port);
    var url = "ws://"+host+":"+port+"/IAMADMIN=TRUE";
    ws = new WebSocket(url);
    ws.onopen = function(){
      isConnect = true;
      ws = encryptionSocket(ws);
      //Controller
      ws.onmessage = function(msg){
        //#Means simple text
        //!Means error
        //if(msg.substr(1) !== ''){
        //  if(msg[0] == '#'){
        //    gTerm.echo(msg.substr(1));
        //  }else if(msg[0] == '!'){
        //    gTerm.error(msg.substr(1));
        //  }/**else{It must be a bug!}*/
        //}
        if(msg !== ''){
          gTerm.echo(msg);
        }
        gTerm.resume();
      };
      gTerm.echo('Connected! :)');
      gTerm.resume();
    };
    ws.onerror  = function(err){
      gTerm.error('Can not connect to port '+port+' on '+host);
      gTerm.resume();
    };
    ws.onclose  = function(){
      isConnect = false;
      gTerm.echo('Connection closed!');
    };
  }
    // Main interpreter function
    function interpreter(input) {
      var command, inputs;
      inputs = input.split(/ +/);
      command = inputs[0];
      gTerm.pause();
      if(command == 'connect'){
        connect(inputs[1],inputs[2]);
      }else if(command == 'help'){
        gTerm.echo(greetings);
        gTerm.echo('[[b;#d33682;]Manual:]\nFor connect to a server you should use \'connect\' command in this format:');
        gTerm.echo('connect [host] [port]');
        gTerm.resume();
      }else if(isConnect){
        ws.send(input);
      }else{
        console.log(command);
        gTerm.error('There is no open connection here.(type \'help\' for more helps)');
        gTerm.resume();
      }
    }

  var name =
      "   ____      ________    _____  _____     _____  \n"+
      "  / __ \\    (___  ___)  (_   _) )__  \\   / ___/  \n"+
      " / /  \\ \\       ) )       | |    __) /  ( (__    \n"+
      "( (    ) )     ( (        | |   (__ (    ) __)   \n"+
      "( (  /\\) )      ) )       | |      \\ \\  ( (      \n"+
      " \\ \\_\\ \\/      ( (       _| |__ ___/  )  \\ \\___  \n"+
      "  \\___\\ \\_     /__\     /_____( )____/    \\____\\ \n"+
      "       \\__)                                      \n";
  var copyRight = "Copyright (c) 2016 QTIƎE\n"+
"Template by http://wedding.jai.im/\n"+
"This program is free software: you can redistribute it and/or modify\n"+
"it under the terms of the GNU General Public License as published by\n"+
"the Free Software Foundation, either version 3 of the License, or\n"+
"(at your option) any later version.\n";

  var greetings = name+copyRight+"[[b;#d33682;]What is PHPSocket Console?]\nIt's a simple tool that gives you ability to control your\nPHPSocket-server and run some commands in server side.";
    gTerm = $('#terminal').terminal( interpreter, {
      prompt: prompt,
      name: 'wedding',
      height: 600,
      tabcompletion: true,
      greetings:''
    });
});