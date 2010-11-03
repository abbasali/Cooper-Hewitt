<?php  global $user; ?>

<?php if (!$user->uid) : ?>


<form action="<?php print "?q=user&".drupal_get_destination();?>" method="post" id="user-login-form" class="form-login">
	
	<p style="text-align: left;">
	<label for="modlgn_username">Username</label><br />
    <input name="name" id="mod_login_username" type="text" alt="username" size="18" value="Username" onfocus="if (this.value=='Username') this.value=''" onblur="if(this.value=='') { this.value='Username'; return false; }" />
	</p>
	
	<p style="text-align: left;">
	<label for="modlgn_username">Password</label><br />
	<input type="password" id="mod_login_password" name="pass" size="18" alt="password" value="Password" onfocus="if (this.value=='Password') this.value=''" onblur="if(this.value=='') { this.value='Password'; return false; }" />
	</p>
	
	<p style="text-align: left;">
   	<div id="sl_rememberme"><input type="checkbox" name="remember" id="mod_login_remember" class="inputbox" value="yes" alt="Remember Me" /> Remember me</div>
	</p>
	
	<p style="text-align: left;">
	<div id="sl_submitbutton">
		<input type="hidden" name="form_id" id="edit-user-login" value="user_login" /> 
		<input type="submit" name="Submit" class="button" value="Login"  />
	</div>
	</p>
	

	<div id="sl_lostpass"><a href="?q=user/password">Lost Password?</a></div>
                    
	<div id="sl_register">No account yet? <a href="?q=user/register">Register</a></div>
	   
</form>


<?php else: ?>

<div id="sl_vert" class="login">
<form action="?q=logout" method="post" name="logout">	
		<div id="greeting">Hi, admin  <br>  <a href="?q=node/add">Create Content</a>  |  <a href="?q=admin">Site Admin</a></div>

		<div id="sl_submitbutton"><input type="submit" name="Submit" class="button" value="Logout" /></div>

</form>
</div>

<?php endif; ?>
