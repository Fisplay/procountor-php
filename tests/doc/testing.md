# Testing

## API testing

Tests which need to test communication with API, need to extend `ApiTestCase`.
This class has a method `createClient(LoggerInterface $logger = null)` which returns an Client object usable for making real api calls.

If no `LoggerInterface` is passed as argument, the method will just mock it.

## Prerequisite

This package has `.env.testing.example` file which needs to be copied as `.env.testing` and all variables filled with development credentials. Only after that will API related tests work.
