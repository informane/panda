<h3>Prysiazhniuk Roman Panda Team test task</h3>
This project was developed by Prysiazhniuk Roman as a test task for Panda Team.
<h3>Description</h4>
<p>
  It serves a web-interface for managing fake surveys (with predefined number of votes) of registered user.
  Also it has API for getting random survey using registered user credentials.
</p>
<h3>Api usage</h3>
<ul>
<li>1. Register account on <a href='http://rompry8.freehostia.com/page/register'>http://rompry8.freehostia.com/page/register</a></li>
<li>2. Login to your account on <a href='http://rompry8.freehostia.com/page/login'>http://rompry8.freehostia.com/page/login</a></li>
<li>3. Create some surveys in your cabinet <a href='http://rompry8.freehostia.com/survey/cabinet'>http://rompry8.freehostia.com/survey/cabinet</a></li>
<li>4. Use curl or postman to get random survey using credentials you set in 1st step. <br><br>
  <b>Example url</b> for account with email=dev.romul@gmail.com and password=123 : <br>
  <b>http://rompry8.freehostia.com/api/getrandomsurvey?email=dev.romul@gmail.com&password=123</b> <br><br>
  <b>Example response (json format):</b> <br>
  {"Who was the first astronaut who set foot on a moon?":[{"answer_text":"Neil Armstrong","votes_number":333},{"answer_text":"Deke Slayton","votes_number":222},{"answer_text":"Mae Jemison","votes_number":111}]}
</li>
</ul>
