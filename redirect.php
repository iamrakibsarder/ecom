<?php
// Redirect to a new page
echo '<b>Successfully created, redirecting........</b>';
header("Location: login.php");
exit; // Make sure to exit after the redirection to prevent further execution
?>