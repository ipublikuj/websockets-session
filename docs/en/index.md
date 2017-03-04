# Quickstart

This extension implement [Nette](https://nette.org) sessions into [ipub/websockets](https://github.com/iPublikuj/websockets) server

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

## Usage

If you want to use session under websockets, you have to use other than default session handler. Memache or Memcached or Redis would be great. Once you have implemented this alternative handler into your application, you could start using session in 
websockets.

After all this steps, session will be available in your controllers. Even user instance will be available.
