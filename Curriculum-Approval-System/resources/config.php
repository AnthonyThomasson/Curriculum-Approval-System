<?php 
// Paths
define("WEBPAGE_TITLE", "Curriculum Approval Tool");

define("TEMPLATES_PATH", "resources/templates/");
define("CLASS_PATH", "resources/class/");
define("CSS_PATH", "resources/css/");
define("QUERY_PATH", "resources/query/");
define("JS_PATH", "resources/js/");
define("FUNCTIONS_PATH", "resources/functions/");
define("PLUGINS_PATH", "resources/plugins/");

//Bootstrap path
define("BOOTSTRAP", "//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css");

//JQuery
define("JQUERY", "//code.jquery.com/jquery-latest.min.js");

// Database settings
define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DB_NAME", "curriculum");

// Send approval notifications from the following email
define("APPROVAL_NOTIFIER_EMAIL", "athom948@mtroyal.ca");

// Approval level stacks
define("MAJOR_CHANGE_STACK", serialize (array("Group1", "Group2")));

?>