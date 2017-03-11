# HIWA is a Horribly Insecure Web Application

## Features

This horribly insecure web application is designed to illustrate
a number of common web application vulnerabilities. Specifically,
among its features are:

 1. SQL injection for authentication bypass
 2. XSS 
 3. Insecure object references allow access control bypass
 4. Insufficient sanitation of input parameters allows privilege escalation
 5. Inappropriate use of encryption stored credentials as plaintext passwords
 6. Insecure file upload capability leads to arbitrary code execution
 7. Lack of transport-layer encryption allows credential sniffing
 8. Unprotected configuration files in browsable directory
 9. Authentication state maintained in client-side cookies
10. Insecure defaults

## Installation

HIWA is written in PHP, using a Postgresql backend. Some hands-on experience
with getting these programs to work is expected by the reader. At a later
time, I might write up more detailed instructions.

###
Dependencies:

* Apache2 (apt install apache2)
* Postgresql (apt install postgresql)
* PHP (apt install libapache2-mod-php5)
* Postgresql connector for PHP5 (apt install php5-pgsql)

## Contact

Kees Leune <kees@leune.org>
[GitHub](https://github.com/KeesL/hiwa)

