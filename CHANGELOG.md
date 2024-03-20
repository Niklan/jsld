# Changelog

## [Unreleased][unreleased]

No changes at this moment.

## [1.3]

### Changed

- `JsldGlobal` service is depricated. He basically has no use.
- Schema moved to the `html_head`, because of problems with the caching in the footer. `#attached` is processed properly no matter what, while `page_bottom` is heavily cached. This is visible on multilingual websites.

[1.3]: https://github.com/Niklan/jsld/compare/8.x-1.2...8.x-1.3
