<?php
	mysqli_query($link, "INSERT INTO community (text, user_id) values ('$_POST[text]', '$_POST[user_id]'");
?>