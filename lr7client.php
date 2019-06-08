<!DOCTYPE html>
<html>
    <head >
        <meta charset="utf-8">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

        <style>
            body {
				width: 610px;
			}

			#frmEnquiry {
				border-top: #F0F0F0 2px solid;
				background: #FAF8F8;
				padding: 15px 30px;
			}

			#frmEnquiry div {
				margin-bottom: 20px;
			}

			#frmEnquiry div label {
				margin-left: 5px
			}

			.demoInputBox {
				padding: 10px;
				border: #F0F0F0 1px solid;
				border-radius: 4px;
				background-color: #FFF;
				width: 100%;
			}

			.demoInputBox:focus {
				outline:none;
			}


			.info {
				font-size: .8em;
				color: #FF6600;
				letter-spacing: 2px;
				padding-left: 5px;
			}

			.btnAction {
				background-color: #263327;
				border: 0;
				padding: 10px 40px;
				color: #FFF;
				border: #F0F0F0 1px solid;
				border-radius: 4px;
				cursor:pointer;
			}
			.btnAction:focus {
				outline:none;
			}
			
			.error input,
			.error textarea {
			  border: 1px solid red;
			}

			.error {
			  color: red;
			}
			

        </style>
    </head>
    <body>	
		<form id="frmEnquiry"  action = "" method = "post" name="mail">
			<div id="mail-status"></div> 
			<div>
				<input
					type="text" name="userName" id="userName"
					class="demoInputBox" placeholder="Имя">
			</div>
			<div>
				<input type="text" name="userEmail" id="userEmail"
					class="demoInputBox" placeholder="Email">
			</div>
			<div>
				<input type="text" name="subject" id="subject"
					class="demoInputBox" placeholder="Тема">
			</div>
			<div>
				<textarea name="content" id="content" class="demoInputBox"
					cols="60" rows="6" placeholder="Сообщение"></textarea>
			</div>
			<div>
				<img src="captcha.php">
				<input id="captcha" type="text" name="captcha_code">
			</div>
			<div>
				<label>Прикрепить</label><br /> <input type="file"
					name="attachment[]" class="demoInputBox" multiple="multiple">
			</div>
			<div>
				<button id="btn" type="button" onClick="sendData()" class="btnAction"> Отправить </button>
			</div>
		</form>	
	</body>
</html>
<script>
	function showError(container, errorMessage) {
	  container.className = 'error';
	  var msgElem = document.createElement('span');
	  msgElem.className = "error-message";
	  msgElem.innerHTML = errorMessage;
	  container.appendChild(msgElem);
	}

	function resetError(container) {
		container.className = '';
		if (container.lastChild.className == "error-message") {
		container.removeChild(container.lastChild);
		}
	}
	
	function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
	}
	
	function validate(form) {
		var elems = form.elements;
		var flag = true;

		resetError(elems.userName.parentNode);
		if (!elems.userName.value) {
		showError(elems.userName.parentNode, ' Укажите от кого.');
		flag = false;
		}

		resetError(elems.userEmail.parentNode);
		if (!elems.userEmail.value) {
		showError(elems.userEmail.parentNode, ' Укажите email.');
		flag = false;
		}else{
			if(!validateEmail(elems.userEmail.value)){
				showError(elems.userEmail.parentNode, ' Невалидный email.');
				flag = false;
			}
		}	

		resetError(elems.subject.parentNode);
		if (!elems.subject.value) {
			showError(elems.subject.parentNode, ' Укажите тему.');
			flag = false;
		}

		resetError(elems.content.parentNode);
		if (!elems.content.value) {
			showError(elems.content.parentNode, ' Отсутствует текст.');
			flag = false;
		}

		resetError(elems.captcha_code.parentNode);
		if (!elems.captcha_code.value) {
		showError(elems.captcha_code.parentNode, ' Введите капчу.');
		flag = false;
		}else{
			if (getCookie("captcha_code") != elems.captcha_code.value){
				showError(elems.captcha_code.parentNode, 'Проверьте капчу.');
				flag = false;
			}
		}	
		return flag;
    }
	
	function sendData(){
		var elem = document.getElementById("btn");
		var cap = document.getElementById("captcha");
		resetError(elem.parentNode);
		if(validate(document.getElementById("frmEnquiry"))){
			var formData = new FormData(document.forms.mail);
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "lr7server.php");
			console.log('OPENED: ', xhr.status);

			xhr.onprogress = function () {
			  console.log('LOADING: ', xhr.status);
			};

			xhr.onload = function () {
			  console.log('DONE: ', xhr.status);
			};
			xhr.send(formData);
		}else{
			showError(elem.parentNode, "Cообщение не отправлено!");
		}
	}
	
	function getCookie(name) {
		var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	}
</script>