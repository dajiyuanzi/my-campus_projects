			<br/><br/>
			<table>
				<tr><td>tid</td><td>name</td><td>like</td><td>dislike</td><td>color</td><td>description</td><td>code</td><td>uid</td></tr>
				<?php require_once('../backend/admin_topic.php'); ?>
			</table>

			<br>

			<legend>Delete Comment</legend>
			<form method="post" action="../frontend/admin.php">
				<p>
					<label for="username" class="label">Id of topic to delete:</label>
					<input id="username" name="tid" type="text" class="input" />
				<p/>
					<input type="submit" name="profile" value="Delete" class="left" />
				</p>
			</form>
