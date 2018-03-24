<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">	
	<script src="./js/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script> const  URL = 'http://54.38.187.177:81/jwt'; </script>
</head>
<body>
<div ng-app="app" ng-controller="Main as main" class="container">
	<div id="formLogin">
		<h1>User Login</h1>
		<input type="text"     class="form-control" ng-model="main.username" placeholder="username" style="width:300px;"><br>
		<input type="password" class="form-control" ng-model="main.password" placeholder="password" style="width:300px;">
		<br>
	</div> 
	<div style="float:left">
		<button class="btn" ng-click="main.register()" id="register">Register</button>
	</div>
	<div style="float:left;margin-left:15px">
		<button class="btn" ng-click="main.login()" id="login">Login</button>
	</div>
	<div class="alert alert-danger" id="ret" style="margin-top:55px;width:300px;display:none;"></div>
	<div style="float:left;margin-left:15px;margin-top:10px">
		<div style="float:left;margin-left:15px;margin-top:10px">
			<button class="btn" ng-click="main.logout()" id="logout" ng-show="main.isAuthed()" style="display:none">Logout</button>
		</div>
		<div style="float:left;margin-left:15px;margin-top:10px" id="username"></div>
		<div>{{main.message}}</div>
	</div>
	<br><br><br>
	<div id="body" style="width:100%;backgroud:red;margin-top:-45px;" ></div>
</div>
<footer class="col-lg-12 text-center" style="position:fixed;bottom:10px">
<a href="mailto:portab76@gmail.com">By PorTab - <?php echo date("Y"); ?></a>
</footer>
<script>

(function()
{
	/*
	*/	
	function authService($window) 
	{
		var srvc = this;
		/*
		*/	  
		srvc.parseJwt = function (token) {
			var base64Url = token.split('.')[1];
			var base64 = base64Url.replace('-', '+').replace('_', '/');
			setLogin(token);
			return JSON.parse($window.atob(base64));
		};
		/*
		*/	
		srvc.saveToken = function (token) {
			$window.localStorage['jwtToken'] = token;
			console.log ("SAVE" );
			$("#logout").css("display","block");
		};
		/*
		*/	
		srvc.logout = function (token) {
			$window.localStorage.removeItem('jwtToken');
			setUnLogin();
		};
		/*
		*/	
		srvc.getToken = function () {
			return $window.localStorage['jwtToken'];
		};
		/*
		*/	
		srvc.isAuthed = function () {
			var token = srvc.getToken();
			if (token) {
			  var params = srvc.parseJwt(token);
			  return Math.round(new Date().getTime() / 1000) <= params.exp;
			} else {
			  return false;
			}
			}
	}
	/*
	*/	
	function userService($http, API, auth) 
	{
		var srvc = this;
		/*
		*/		
		srvc.register = function (username, password) {	  
			var url = API + '/controllers/register.php?u='+username+"&p="+password;
			$.ajax({url: url ,beforeSend: function( xhr ) {xhr.overrideMimeType( "text/plain; charset=x-user-defined" );}})
			.done(function( data ) {					
					var data = data.replace("####", "");	
					var obj = JSON.parse(data);
					$("#ret").html(obj["message"]);
					$("#ret").attr("style", "display:block;margin-top:55px;width:300px;");
					if(obj["ret"]==1) { $("#ret").removeClass( "alert-warning alert-danger  alert-info" ).addClass( "alert-success" );  }
					else {				$("#ret").removeClass( "alert-warning alert-success alert-info" ).addClass( "alert-danger" );   }	
			});
			return $http.post(API + '/controllers/black.php');
		};
		/*
		*/		  
		srvc.login = function (username, password ,auth ) {
			 var url = API + '/controllers/autentica.php?u='+username+"&p="+password;
			console.log(url);
			$.ajax({url: url ,beforeSend: function( xhr ) {xhr.overrideMimeType( "text/plain; charset=x-user-defined" );}})
			.done(function( data ) {					
					var data = data.replace("####", "");	
					var obj = JSON.parse(data);
					if(obj["ret"]==1) { auth.saveToken(obj["token"]);setLogin(obj["token"]);}	
					else {
							$("#ret").html(obj["message"]);
							$("#ret").attr("style", "display:block;margin-top:55px;width:300px;");
							$("#ret").addClass( "alert " );
							$("#ret").removeClass( "alert-warning alert-success alert-info" ).addClass( "alert-danger" );		
					}
			});		
			return $http.post(API + '/controllers/black.php');
		};

	}
	/*
	*/	
	function MainCtrl(user, auth) {
		var self = this;
		/*
		*/	
		function handleRequest(res) {
			var token = res.data ? res.data.token : null;
			if(token) { 
			console.log('JWT:', token);
			}
			self.message = res.data.message;
		}
		/*
		*/	
		self.login = function() {
			user.login(self.username, self.password ,auth )
			.then(handleRequest, handleRequest)
		}
		self.register = function() {
			user.register(self.username, self.password)
			.then(handleRequest, handleRequest)
		}
		/*
		*/		
		self.logout = function() {
			auth.logout && auth.logout()
		}
		/*
		*/		
		self.isAuthed = function() {
			return auth.isAuthed ? auth.isAuthed() : false
		}
	}

	angular.module('app', [])
		.service('user', userService)
		.service('auth', authService)
		.constant('API', URL)
		.controller('Main', MainCtrl)
})();
/*
*/
function setLogin(token)
{
	$("#logout").css("display","block");
	$("#login").css("display","none");
	$("#register").css("display","none");
	$("#formLogin").css("display","none");
	url = URL + '/controllers/verifica.php?t='+token;
	$.ajax({url: url,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
	}).done(function( data ) {
		 var obj = JSON.parse(data);
		$("#username").html( obj["username"] + "<br>" + timeConverter(obj["time"]) );
		if(obj["ret"]==1) { 
			var url2 = URL + '/index.php?p=controllers/clientes&t='+token;;
			$.ajax({url: url2,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
			}).done(function( data ) {
				$("#ret").attr("style", "display:none");
				$("#body").html(data);
			});
		}	
	});	
}
/*
*/
function setUnLogin()
{
	$("#logout").css("display","none");	
	$("#login").css("display","block");
	$("#register").css("display","block");
	$("#formLogin").css("display","block");		
	$("#ret").html("");
	$("#username").html("");
	$("#body").html("");
}
/*
*/
function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}
</script>
</body>
</html>