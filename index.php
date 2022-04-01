<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>    
      <div id="header">
          <p style="margin-left:115px;">friendsbook</p>
		  <form id="form1" action="login.php" method="post">
            <input type="email" name="email" placeholder="Email" required="required">
            <input type="password" name="pass" placeholder="Password" required>
            <input type="submit" value="Login" name="login" style="height:40px;"/> 
          </form>
      </div>
      <div id="content">
        <div>
          <img src="images/images.jpeg" style="float:left; margin-top:65px; width:35%;">
        </div>
        <div id="form2">
          <form  action="insert_user.php" method="post" autocomplete="on">
            <h3 style="margin-bottom: -15px;">Create a new account</h3>
            <p>Its quick and easy !!</p>
            <input type="text" name="u_name" placeholder="Name" required>
            <input type="email" name="u_email" placeholder="Email" required>
            <input type="password" name="u_pass" placeholder="Password" required>
            <input type="text" name="u_country" placeholder="Country" required>
			<p style="margin-bottom: -15px;">Birthday</p>
            <input type="date" name="u_birthday" placeholder="Birthday" required>
            <select name="u_gender" required>
              <option>Male</option>
              <option>Female</option>
            </select>
			<input type="submit" value="sign_up" name="sign_up"/> 
           </form>
        </div>	
      </div>
  </body>
</html>
