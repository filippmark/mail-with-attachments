<?php
		$uid = md5(uniqid(time()));

		$header = "From: ".$_POST["userName"]." <fil.filipp.2019@mail.ru>\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

		$theme = $_POST["subject"];
		$text = $_POST["content"];
		
		$nmessage = "--".$uid."\r\n";
		$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$nmessage .= $text."\r\n\r\n";
		$nmessage .= "--".$uid."\r\n";

		$fd = fopen("testik.txt", 'w');
		foreach ($_FILES["attachment"]["name"] as $k => $v) {
				$text = $text.$_FILES["attachment"]["tmp_name"][$k];
				$content = file_get_contents($_FILES["attachment"]["tmp_name"][$k]);
				$content = chunk_split(base64_encode($content));
				$nmessage .= "--".$uid."\r\n";
				$nmessage .= "Content-Type: application/octet-stream; name=\"".$_FILES["attachment"]["name"][$k]."\"\r\n";
				$nmessage .= "Content-Transfer-Encoding: base64\r\n";
				$nmessage .= "Content-Disposition: attachment; filename=\"".$_FILES["attachment"]["name"][$k]."\"\r\n\r\n";
				$nmessage .= $content."\r\n\r\n";
				$nmessage .= "--".$uid."\r\n";
				$nmessage .= "--".$uid."--";
		}
		fputs($fd, $text);
		mail($_POST["userEmail"], $theme, $nmessage, $header);
																																																																		