# TriggrPHP
A lightweight PHP event handling system.

[![Packagist](https://img.shields.io/packagist/v/thephpeffect/triggr-php.svg)]() 
[![Build Status](https://travis-ci.org/thephpeffect/TriggrPHP.svg)](https://travis-ci.org/thephpeffect/TriggrPHP) 
[![Packagist](https://img.shields.io/packagist/l/thephpeffect/triggr-php.svg)]() 
[![Dependency Status](https://www.versioneye.com/user/projects/56b3ba5e0a0ff5002c85ed7b/badge.svg)](https://www.versioneye.com/user/projects/56b3ba5e0a0ff5002c85ed7b) 
[![codecov.io](https://codecov.io/github/thephpeffect/TriggrPHP/coverage.svg)](https://codecov.io/github/thephpeffect/TriggrPHP) 

This system allows you to set events and event handlers, fire the events and control the event flow. This is a great way to enabled developers to add event hooks to software.

Note: This is not a replacement for major frameworks like ReactPHP, but more of a supplement tool for other frameworks and situations where event handling would be convenient.

# Installation

The recommended way to install Triggr is through composer(https://getcomposer.org/). Type the following command in your shell environment:

php ~/composer.phar require thephpeffect/trigger-php

# Usage

#### Event Phrase
Using TriggrPHP requires the creation of event phrases. Essentially, an event phrase is an event name with or without a handler name in this format: EventName:HandlerName (or just EventName alone).

These event phrases are used create events. In the case where no handler name is given, one is automatically created. the developer has the option to include a handler name to make what they are doing more clear if they would like.

#### Firing Events
When bulding out an application you would use the "fire" method to specify where you want actions to occur, such as a pre, or post save method on an Entity. The event phrase contains only the event name, all handlers on that event are fired.
```php
Triggr::fire("EventName");
```
If you need to provide data to the event to be used by it's handlers, you may pass an array of arguments.
```php
Triggr::fire("EventName", array($arg1, $arg2, $arg3));
```
In the case that it is needed to fire a specific handler on an event, the fireHandler method may be used. The event phrase this time must have both event name and handler name. Note that arguments are still available to be passed in.
```php
Triggr::fireHandler("EventName:HandlerName", array($arg1));
```

#### Watching Events
Once events are firing within your application you can "watch" them and perform actions when they fire. To do this, you will call the "watch" method. Every "watch" creates a handler. If you provide an event name or the full event phrase determines if TriggrPHP assigns a handler name for you, or not. It is not necessary to assign each handler it's own name, but it can be useful for more complex uses.

To simply watch an event, provide a name and an action. The action can be any callable, so class methods and procedural methods are all usable.
```php
// With event name only
Triggr::watch("MyEvent", function(){ echo "Event has fired!"; });

// With full event phrase (nameing the handler ourselves)
Triggr::watch("MyEvent:FireMessage", function(){ echo "Event has fired!"; });
```

Watch actions may return data, the "fire" method will pass the data along. Since there may be multiple handlers per event, the returned data is provided in an array, sorted by the order that the handlers were run.
Note: "fireHandler" returns mixed data, whatever the "watch" action returns, it returns since there is no potential for multiple handlers.
```php
Triggr::watch("HelloWorld", function(){ return "Hello World"; });
$output = Triggr::fire("HelloWorld"); // Returns array("Hello World")
```

#### Options
When watching an event, options can be provided to the handler for a couple of reasons, to limit the number of times it can be run and to set a sort order or priority
Defaults: RunLimit = 0, Priority = 100 (A run limit of 0 is infinite).
```php
Triggr::watch("HelloWorld", function(){ return "Hello World"; }, array("RunLimit"=>1, "Priority"=>101));
```
