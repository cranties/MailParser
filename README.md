# MailParser

MailParser is a PHP class that simplifies the process of sending emails using the powerful [PHPMailer](https://github.com/PHPMailer/PHPMailer) library. It's designed to make sending template-based emails quick and easy.

## Features

-   **Easy to use:** A simple, intuitive interface for sending emails.
-   **Template-based:** Use HTML templates to create your email content, separating your code from your email design.
-   **PHPMailer integration:** Leverages the power and reliability of PHPMailer for sending emails.

## Getting Started

### Prerequisites

-   PHP 5.0 or higher
-   [PHPMailer](https://github.com/PHPMailer/PHPMailer) library

### Installation

1.  Download and include the `PHPMailer` library in your project.
2.  Place the `PHPMailParser.php` file in your project directory.
3.  Create a `mailtemplate` directory in the same directory as `PHPMailParser.php`.

## Usage

Here's a simple example of how to use MailParser to send an email:

```php
<?php

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';
require 'PHPMailParser.php';

// Create a new MailParser instance
$mail = new MailParser();

// Set the recipient's email address
$mail->SetMailTo('recipient@example.com');

// Set the email template to use
$mail->SetMailTemplate('test');

// Set the variables to be replaced in the template
$mail->SetVariables(['https://example.com']);

// Send the email
$result = $mail->SEND();

echo $result;

?>
```

## Email Templates

MailParser uses a simple templating system to generate email content. Templates are stored in the `mailtemplate` directory. For each template, you need to create two files:

-   `_obj.html`: This file contains the subject of the email.
-   `_body.html`: This file contains the HTML body of the email.

For example, if you set the template to `test`, MailParser will look for `mailtemplate/test_obj.html` and `mailtemplate/test_body.html`.

### Template Variables

You can use variables in your email templates, which will be replaced with the values you provide. To define the number of variables in your template, add a two-digit number to the first line of the `_body.html` file. For example, if you have one variable, the first line of the file should be `01`.

Variables are represented by `###<number>###` in the template, where `<number>` is a two-digit number starting from `01`.

Here's an example of a `mailtemplate/test_body.html` file:

```html
01
<html>
  <body>
    <h1>Welcome!</h1>
    <p>This is a test email from MailParser.</p>
    <p>Click the link below to visit our website:</p>
    <a href="###01###">###01###</a>
  </body>
</html>
```

And the corresponding `mailtemplate/test_obj.html` file:

```
Test Email from MailParser
```

## Contributing

Contributions are welcome! If you find a bug or have a suggestion for a new feature, please open an issue or submit a pull request.

## License

This project is licensed under the MIT License.
