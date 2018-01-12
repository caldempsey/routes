<? @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Use PHP to compile necessary files -->
    <!--Uses PHP to get bootstrap head info-->
    <?php include 'static/head/bootstrap.html'; ?>
    <!--Uses PHP to get navbar head info-->
    <?php include 'static/head/navbar.html'; ?>
    <!--Uses PHP to get select head info-->
    <?php include 'static/head/select.html'; ?>
    <!--Uses PHP to get moment head info-->
    <?php include 'static/head/moment.html'; ?>
    <!--Uses PHP to get datetimepicker head info-->
    <?php include 'static/head/bootstrap_datetimepicker.html'; ?>
    <!--Uses PHP to get index specific head info-->
    <?php include 'static/head/index.html'; ?>
</head>

<body>

<!-- Uses PHP to get the default navbar -->

<?php include 'static/page_navbar/navbar.php'; ?>

<!-- End of navbar -->

<div class="form">
		<h2>What should I do if no routes are found between my two destinations? </h2>
		<br>
		<p> Contact us using any of the details at the bottom of the page for more details. </p>
		<br>
		<h2>In what format should I input the dates of my departure and arrival? </h2>
		<br>
		<p>Use our simple date picker to pick a date on the calendar.</p>
		<br>
		<h2>What should I do if I think there is a problem with the website? </h2>
		<p>Use any of the contact details at the bottom right of the screen to get in touch with us. </p>
		<br>
		<h2>Do you have any dyslexia support?</h2>
		<p>Our website is dyslexia friendly. Dyslexic people can find it hard to read plain black text on a white background. We have therefore modified our website to ensure that users are reading white text on a coloured background. If you have any feedback on this please advise using the contact details provided below.</p>
	<br>
	<h2> Contact Us  </h2>
	<br>
	<p> 23 Claremont Road </p>
	<p> Newcastle </p>
	<p> NE2 4AN </p>
	<p> b6080724@newcastle.ac.uk </p>
	<p> 07845789432 </p>

</div>

</body>
</html>
