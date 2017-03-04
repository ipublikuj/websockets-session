# WebSockets session

[![Build Status](https://img.shields.io/travis/iPublikuj/websockets-session.svg?style=flat-square)](https://travis-ci.org/iPublikuj/websockets-session)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/iPublikuj/websockets-session.svg?style=flat-square)](https://scrutinizer-ci.com/g/iPublikuj/websockets-session/?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/iPublikuj/websockets-session.svg?style=flat-square)](https://scrutinizer-ci.com/g/iPublikuj/websockets-session/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/ipub/websockets-session.svg?style=flat-square)](https://packagist.org/packages/ipub/websockets-session)
[![Composer Downloads](https://img.shields.io/packagist/dt/ipub/websockets-session.svg?style=flat-square)](https://packagist.org/packages/ipub/websockets-session)
[![License](https://img.shields.io/packagist/l/ipub/websockets-session.svg?style=flat-square)](https://packagist.org/packages/ipub/websockets-session)

Extension for implementing [Nette Framework sessions](http://nette.org/) into [WebSockets](http://socketo.me/) 

## Installation

The best way to install ipub/websockets-session is using  [Composer](http://getcomposer.org/):

```sh
$ composer require ipub/websockets-session
```

After that you have to register extension in config.neon.

```neon
extensions:
	webSocketsSession: IPub\WebSocketsSession\DI\WebSocketsSessionExtension
```

## Documentation

Learn how to create sessions under websockets in [documentation](https://github.com/iPublikuj/websockets-session/blob/master/docs/en/index.md).

***
Homepage [http://www.ipublikuj.eu](http://www.ipublikuj.eu) and repository [http://github.com/iPublikuj/websockets-session](http://github.com/iPublikuj/websockets-session).
