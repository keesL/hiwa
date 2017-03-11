# HIWA is a Horribly Insecure Web Application

## Features

This horribly insecure web application is designed to illustrate
a number of common web application vulnerabilities. Specifically,
among its features are:

1. SQL injection allows authentication bypass
2. XSS in product descriptions
3. Access control mechanism only enforces privileges in the menu options; deep links
   will bypass.
4. Insufficient sanitation of input parameters allows privilege escalation via
   cookie manipulation
5. Passwords and social security numbers are stored in plaintext
6. No password complexity requirements
7. Insecure file upload capability leads to arbitrary code execution
8. Lack of transport-layer encryption allows credential sniffing
9. Unprotected configuration files in browsable directory
10. Authentication state maintained in client-side cookies
11. Insecure defaults
12. CSRF vulnerabilities allow deletion of customers, products and users

## Installation

HIWA is written in PHP, using a Postgresql backend. Some hands-on experience
with getting these programs to work is expected by the reader. At a later
time, I might write up more detailed instructions.

## TODO

* Fix (most) SQL and XSS issues in customers, products, orders and users
* Come up with some documentation (installation, usage, as well as fixing)

### Dependencies:

* Apache2 (apt install apache2)
* Postgresql (apt install postgresql)
* PHP (apt install libapache2-mod-php5)
* Postgresql connector for PHP5 (apt install php5-pgsql)

## Contact

Kees Leune <kees@leune.org>

[GitHub](https://github.com/KeesL/hiwa)

