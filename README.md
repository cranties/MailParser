# MailParser
PHP Mail Parser to use with PHPMailer

Version 0.1

USAGE:

					$test = new MailParser();
					$test->SetMailTo($emailcli);
					$test->SetMailTemplate("bdc_authko");
					$test->SetVariables([$link]);
					$test->SEND();
