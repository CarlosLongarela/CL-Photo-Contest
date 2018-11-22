# CL Photo Contest

## PHPCS
for evaluate entire project excecute in project dir:

```bash
# phpcs --standard=phpcs.ruleset.xml --extensions=php ./
```

## Font Icons

* Font Name: [WordPress Dashicons](https://developer.wordpress.org/resource/dashicons/)
* Font Name: [WooCommerce (Glyphs: 68)](https://rawgit.com/woothemes/woocommerce-icons/master/demo.html)
* [Font Awesome](https://fontawesome.com/)
* Convert icons fron Font Awesome to png: http://fa2png.io/
* Generate font icons with [IcoMoon](https://icomoon.io/app/#/select)

## Syntax

* [BEM Naming](http://getbem.com/naming/)

## Instructions for developers in plugin development process

* For development and gulp task we must be in root plugin folder and execute `$ npm install`
* Folder ___node_modules___ isn't tracked in Git and we must update npm modules (previous step)
* Whitelist phpcs errors: https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Whitelisting-code-which-flags-errors and https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage

## Available flags for whitelists

### Escaping / XSS
_WPCS 2013-06-11 +_

`// WPCS: XSS ok.`

### Sanitization
_WPCS 0.4.0+_

`// WPCS: sanitization ok.`

### Nonce verification / CSRF
_WPCS 0.5.0+_

`// WPCS: CSRF ok.`

### Loose comparison
_WPCS 0.4.0+_

`// WPCS: loose comparison ok.`

### Overriding WordPress globals
_WPCS 0.3.0+_

`// WPCS: override ok.`

### Unprepared SQL
_WPCS 0.8.0+_

`// WPCS: unprepared SQL ok.`

Tip: before whitelisting a query, if you are passing user-supplied data through `$wpdb->prepare()` as part of the `$query` parameter, even if that data is properly escaped, you also need to check that it is does not make the query vulnerable to [`sprintf()`-related SQLi attacks](https://blog.sucuri.net/2017/02/sql-injection-vulnerability-nextgen-gallery-wordpress.html).

### Use of superglobal
_WPCS 0.3.0+_

`// WPCS: input var ok.`

### Direct database query*
_WPCS 0.3.0+_

`// WPCS: db call ok.`

### Database query without caching*
_WPCS 0.3.0+_

`// WPCS: cache ok.`

### Slow (taxonomy) queries
_WPCS 0.12.0+_

`// WPCS: slow query ok.`

This flag was originally called `tax_query` and introduced in WPCS 0.10.0.
The `tax_query` whitelist flag has been deprecated as of WPCS 0.12.0 and is superseded by the `slow query` flag.

### Non-prefixed function/class/variable/constant in the global namespace
_WPCS 0.12.0+_

`// WPCS: prefix ok.`

### WordPress spelling
_WPCS 0.12.0+_

`// WPCS: spelling ok.`

### Precision alignment
_WPCS 0.14.0+_

`// WPCS: precision alignment ok.`

### PreparedSQL placeholders vs replacements
_WPCS 0.14.0+_

`// WPCS: PreparedSQLPlaceholders replacement count ok.`

## When to Use

These flags are provided for convenience, but using them should generally be avoided. Most of the time you can fix the error by either refactoring your code or by updating the configuration of WPCS.

Using our example above, ideally, we might refactor the code to be something like this:

```php
function some_html() {
    echo '<strong>bar</strong>';
}
```

This not only pleases WPCS, but it also makes it easier for you to see that the output is safe when reviewing the code.

Another possibility would be a less drastic refactoring of the code, in combination with an improved configuration for WPCS. If the `some_html()` function's return value is always escaped, we could add it to the list of auto-escaped functions by adding this in our XML config file:

```xml
<rule ref="WordPress.XSS.EscapeOutput">
	<properties>
		<property name="customAutoEscapedFunctions" value="some_html" type="array" />
	</properties>
</rule>
```

Then, if we refactored the code like this, WPCS would know that the value was escaped, and would automatically suppress the error:

```php
function some_html() {
    return '<strong>bar</strong>';
}

echo some_html();
```

There are cases where refactoring is impractical or impossible, but usually, you can avoid littering your code with these flags by doing just a very little work. That way, you not only shut up WPCS, you also improve your code in the process!

---
\* For historical reasons, the `cache` and `db call` flags cannot currently be used together like this as the other flags can: `cache, db call ok.` Instead, they have to be used together like this: `cache ok, db call ok.` (each must be immediately followed by `ok`). They also behave slightly different than other flags when used in multi-line statements: other flags need to come at the end of the first line of the statement, while these two are required to come after the `;` on the last line instead.
