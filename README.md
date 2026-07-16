# Open-Realty

**Description**: Open-Realty is a web-based real estate listing management and lead generation content management system (CMS) that is designed to be very reliable and flexible as a framework for creating and managing a real estate website.

**Languages**: English, Español, Português, Português-Brasil

**Screenshot**:

![](https://gitlab.com/appsbytherealryanbonham/open-realty/-/raw/main/screenshot.png)

## Dependencies

- PHP v7.4.3+ (Including PHP8+)
- MySQL 5.5 - 5.7
- PHP GD Support or Imagemagik
- PHP Multibyte String Support
- PHP CURL support
- PHP OpenSSL support
- PHP ZIP support
- PHP Short Tag support disabled
- PHP Safe Mode disabled
- PHP magic_quotes set to OFF (in all program folders)
- PHP session.auto_start disabled (session.auto_start = "0")
- PHP SuExec/SuPHP (recommended for automatic upgrades)
- APACHE mod_rewrite (required for SEO Friendly URLs)
- APACHE mod_expires (recommended)
- APACHE mod_headers (recommended)

## Installation

[Installation Guide](https://docs.open-realty.org/nav.guide/01.installation/)

## Setting up a development env on gitpod.io.

You can use (www.gitpod.io)[gitpod.io] to run an open-realty development env. [![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://gitlab.com/appsbytherealryanbonham/open-realty)

## Setting Up Development Env on Windows

1.  Install Chocolatey from https://chocolatey.org/install

2.  Install Docker Desktop

    `choco install docker-desktop -y`

3.  Install Make
    `choco install make -y `
4.  Install Git

    `choco install git -y`

5.  Restart Windows (needed to get docker desktop running)

6.  Follow the direction and set up an SSH key for accessing GitLab.
    See: https://docs.gitlab.com/ee/ssh/

7.  Start Docker Desktop

## Running Open-Realty from source for development

1. Clone our GitLab repo or your [fork](https://docs.gitlab.com/ee/user/project/repository/forking_workflow.html). _Forking is recommended, as you will need to commit your changes to your fork and open a merge request back to our repo in order to contribute your changes._

   `git clone git@gitlab.com:appsbytherealryanbonham/open-realty.git`

2. Change into the open-realty directory that was just created.

   `cd open-realty`

3. Start Open-Realty and install all dependencies

   `make install`

4. Run the Open-Realty installer at http://localhost:8100/

   1. Database Server: db
   2. Database Name: openrealty
   3. Database User: openrealty
   4. Database Password: orpassword

5. When you are done, you can run the following to stop the docker containers:

   `make stop`

   Alternatively, if you want to teardown the docker containers and any saved data in your database run:

   `make teardown`

## Getting help

For general help, try our [Discord server](https://discord.gg/uU7EYnxW).
If you have a feature request or bug reports, etc, please file an issue in this repository's Issue Tracker.

## Getting involved

See our [CONTRIBUTING](CONTRIBUTING.md) guide.

---

## Open source licensing info

[MIT LICENSE](LICENSE)
