# MailParser
PHP Mail Parser to use with PHPMailer

Version 0.1

USAGE:

					$test = new MailParser();
					$test->SetMailTo("emailtome@google.com");
					$test->SetMailTemplate("test");
					$test->SetVariables(["https://github.com"]);
					$test->SEND();
