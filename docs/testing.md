# Testing

This project uses [Pest](https://pestphp.com/) with [Mockery](https://pestphp.com/docs/plugins/mock) as a testing framework. Note that tests utilize PHP8 language features, so even thgough the library itsel is PHP7 compatilbe, tests are not.

Tests are separated into:
-  Feature tests
    - located under /tests/Feature
    - bound to [ApiTestCase](../tests/ApiTestCase.php), ie. `test` and  `it` function callbacks use it as a `$this` context
    - if your test communicates with API or spans across several functionalities, it belongs here
- Unit tests
    - located under /tests/Unit
    - bound to [UnitTestCase](../tests/UnitTestCase.php), `$this` context works as above


## Mockery & VS Code Intelephense

There is a [known bug](https://github.com/bmewburn/vscode-intelephense/issues/1784) where Mockery::mock returns a MockInterface, but Intelephense _thinks_ it returns a string. This causes false errors on static analysis, so make sure to define mocks like this;
```php
/** @var MockInterface $logger */
$logger = mock(LoggerInterface::class);
$logger = $logger->shouldReceive('info')
    ->with(Mockery::capture($logMessage), Mockery::capture($logContext))
    ->once()
    ->mock();
/** @var LoggerInterface $logger */
```
