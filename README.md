LittleWikitext
=====================

LittleWikitext is a simple parser for something not unlike wikitext.

Markup language and HTML output
-------------------------------
Informal markup spec:
* A document has a set of sections, as well as possibly an unnamed initial
section.
* Each section is made up of a heading and some content.  The content can be
list items of various nesting depths, or paragraphs of text.  There are also
two types of inline content: links and inclusions.
* The heading is marked up as below. Whitespace around the heading is ignored.
```
== TODO HEADING ==
```
* A list item is marked up as given below. Whitespace after the star(s) is ignored.
```
* this is a list item
** this is a nested list item
```
* A link looks like this: `[[Target|caption]]`
* An inclusion looks like this: `{{Target}}`
* Whitespace is ignored around a caption and the target of a link or inclusion.

See [`sample.markup`](./sample.markup) for an example.

Informal HTML output spec:
* Sections are wrapped in a `<section>` tag
* Headings are wrapped in a `<h2>` tag
* Lists are generated using `<ul>` lists
* Paragraphs are surrounded by `<p>` tags
* Links correspond to `<a>` tags, with the target in the `href` attribute
* Inclusions correspond to empty `<template>` tags, with the target in the
`id` attribute

See [`sample.html`](./sample.html) for the output given for the sample markup.

Code
----
The code you will need is in [`src`], `tests`/[`LittleWikitextTest.php`], and
`tests`/[`parserTests.txt`].  There is an in-depth walkthough in
[WALKTHROUGH.md](./WALKTHROUGH.md).

Tasks
-----
There are two tasks to complete.  We do not expect you to spend more
than 60 minutes on these.  You will be evaluated primarily on task 1,
your test cases for task 2, and your ability to discuss the design
issues during the followup technical interview, not on the quantity of
code you can write in 60 minutes.

### Task 1

Start by getting familiar with the code base and how it is organized.
Once you have a feel for it, run `composer test` to execute the test
suite - it will fail with a single error. The test cases live in
`tests`/[`parserTests.txt`]. Track down the bug and fix the code so
that the test passes.

The goal of Task 1 is mostly to familiarize yourself with the code base.

### Task 2

We would like to implement **inclusions**: for every instance of
`{{Foo}}` in the input wikitext, we should replace it in the output
with the contents of the section titled `Foo`.

Please provide *test cases* which demonstrate the behavior of the new
feature.  If you have time, you may implement code to make some or all
of the tests pass, but you should consider the implementation mostly
as an aid to writing good tests and thinking through the specification
issues.  Be sure your test cases demonstrate not just basic
functionality but also interesting corner cases.

Please ensure that the output you expect is always valid HTML; we’ve
provided code in
[`tests/ValidHtmlTest.php`](./tests/ValidHtmlTest.php) to help you
check.  This will entail some choices about how certain constructs are
rendered; be prepared to describe and justify your choices.

We will note that our markup language, like wikitext, is made for
humans not machines: simply crashing with a "syntax error" message is
not a good idea. (Crashing without a message is even worse!)  It is
often helpful to honor the intent of the author of the markup and
provide output that is useful to readers, even if the markup input is
“incorrect”. Similarly, consider how to maximize the expressiveness of
your markup language and the power of the inclusion mechanism, which
may suggest stripping headings and wrappers in your inclusion. There
isn’t a single “right” answer, so be prepared to discuss your choices
during the follow-up interview, especially alternatives that differ
from your submitted implementation.

### Wrapping up

Please do not fork the provided github repository or submit pull
requests, as they may be visible to other applicants.

Instead zip or tar up the code directory and upload it to greenhouse.

We are aware the time constraint won’t permit much polish.
This tech task is ultimately about communication, both reading
and writing.  We’re not going to put your submission into production,
but we *are* going to read it and talk to you about it during the
followup interview.

License
-------

This code is distributed under the MIT license; see
[LICENSE](./LICENSE) for more info.

---
[wikipeg]: https://www.npmjs.com/package/wikipeg
[PEG]: https://en.wikipedia.org/wiki/Parsing_expression_grammar
[`src`]: ./src
[`parserTests.txt`]: ./tests/parserTests.txt
[`LittleWikitext.php`]: ./src/LittleWikitext.php
[`LittleWikitextTest.php`]: ./tests/LittleWikitextTest.php
[`Grammar.pegphp`]: ./src/Parser/Grammar.pegphp
[`Grammar`]: ./src/Parser/Grammar.php
[`Node`]: ./src/AST/Node.php
[`LeafNode`]: ./src/AST/LeafNode.php
[`Root`]: ./src/AST/Root.php
[`Section`]: ./src/AST/Section.php
[`Heading`]: ./src/AST/Heading.php
[`ListItem`]: ./src/AST/ListItem.php
[`Paragraph`]: ./src/AST/Paragraph.php
[`Inclusion`]: ./src/AST/Inclusion.php
[`Link`]: ./src/AST/Link.php
[`Text`]: ./src/AST/Text.php
[`Visitor`]: ./src/Visitors/Visitor.php
[`TraversalVisitor`]: ./src/Visitors/TraversalVisitor.php
[`TransformVisitor`]: ./src/Visitors/TransformVisitor.php
[`ToHtmlVisitor`]: ./src/Visitors/ToHtmlVisitor.php
[`ToMarkupVisitor`]: ./src/Visitors/ToMarkupVisitor.php
[`LittleWikitext`]: ./src/LittleWikitext.php
[`ValidHtmlTest`]: ./tests/ValidHtmlTest.php
[`LittleWikitextTest`]: ./tests/LittleWikitextTest.php
[PHPUnit]: https://phpunit.de/documentation.html
[`phpcs`]: https://github.com/squizlabs/PHP_CodeSniffer
[`phan`]: https://github.com/phan/phan/wiki
[composer]: https://getcomposer.org/
