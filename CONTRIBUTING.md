# Contributing to Open-Realty

When contributing to the development of Open-Realty, please first discuss the change
you wish to make via issue, email, or any other method with the maintainers before
making a change.

Please note we have a [Code of Conduct](#code-of-conduct), please follow it in all
your interactions with the project.

# Table of contents
1. [Creating an issue](#issues-issues-and-more-issues)
  1. [Template](#issue-template)
2. [Pull requests](#pull-request-process)
3. [Code of Conduct](#code-of-conduct)

# Issues, issues and more issues!

There are many ways you can contribute to Open-Realty, and all of them involve creating issues
in [Open-Realty issue tracker](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issuess). This is the
entry point for your contribution.

To create an effective and high quality ticket, try to put the following information on your
ticket:

 1. A detailed description of the issue or feature request
     - For issues, please add the necessary steps to reproduce the issue.
     - For feature requests, add a detailed description of your proposal.

## Issue template
```
[Title of the issue or feature request]

Detailed description of the issue. Put as much information as you can, potentially
with images showing the issue or mockups of the proposed feature.

If it's an issue, add the steps to reproduce like this:

Steps to reproduce:

1. Open Open-Realty
2. Create a listing
3. ...

```



# Pull Request Process

1. Ensure your code compiles. Run `make test` before creating the pull request.
2. Make sure your code is correclty formated. Run `make php-cs-fixer`
3. Update any relavant documentation in our [documentation repo](https://gitlab.com/appsbytherealryanbonham/docs.open-realty.org)
3. The commit message is formatted as follows:

```
   component: <summary>

   A paragraph explaining the problem and its context.

   Another one explaining how you solved that.

   <link to the bug ticket>
```

4. Once the maintainers review and approve your MR it will get merged into the "main" branch and be included in the next release.

---

# Code of Conduct



The Open-Realty community creates software for a better world. We achieve this by behaving well towards
each other.

Therefore this document suggests what we consider ideal behaviour, so you know what
to expect when getting involved in the Open-Realty community. This is who we are and what we want to be.
There is no official enforcement of these principles, and this should not be interpreted
like a legal document.

## Advice

 * **Be respectful and considerate**: Disagreement is no excuse for poor behaviour or personal
     attacks. Remember that a community where people feel uncomfortable is not a productive one.

 * **Be patient and generous**: If someone asks for help it is because they need it. Do politely
     suggest specific documentation or more appropriate venues where appropriate, but avoid
     aggressive or vague responses such as "RTFM".

 * **Assume people mean well**: Remember that decisions are often a difficult choice between
     competing priorities. If you disagree, please do so politely. If something seems outrageous,
     check that you did not misinterpret it. Ask for clarification, but do not assume the worst.

 * **Try to be concise**: Avoid repeating what has been said already. Making a conversation larger
     makes it difficult to follow, and people often feel personally attacked if they receive multiple
     messages telling them the same thing.


In the interest of fostering an open and welcoming environment, we as
contributors and maintainers pledge to making participation in our project and
our community a harassment-free experience for everyone, regardless of age, body
size, disability, ethnicity, gender identity and expression, level of experience,
nationality, personal appearance, race, religion, or sexual identity and
orientation.

---

# Attribution

This Code of Conduct is adapted from the [Contributor Covenant][homepage], version 1.4,
available at [http://contributor-covenant.org/version/1/4][version]

[homepage]: http://contributor-covenant.org
[version]: http://contributor-covenant.org/version/1/4/
