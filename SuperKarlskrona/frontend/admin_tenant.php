<br/><br/>
			<table>
				<tr><td>rid</td><td>address</td><td>description</td><td>contact</td><td>uid</td></tr>
				<?php require_once('../backend/admin_tenant.php'); ?>
			</table>

			<br>

			<legend>Delete Comment</legend>
			<form method="post" action="../frontend/admin.php?page=tenant"> <!--Dont forget add get['page']=tenant !!! -->
				<p>
					<label for="username" class="label">Id of advert to delete:</label>
					<input id="username" name="rid" type="text" class="input" />
				<p/>
					<input type="submit" name="delete" value="Delete" class="left" />
				</p>
			</form>
