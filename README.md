# TriggrPHP
A lightweight PHP event handling system.

This system allows you to set events and event handlers, fire the events and control the event flow. This is a great way to enabled developers to add event hooks to software.

# Examples


#####Fire an event anywhere in your code:
Triggr::fire("MyEvent");

#####Watch any event and perform actions:
Triggr::watch("MyEvent", function(){ echo "Event has fired!"; });

#####Name your individual handlers for more control later:
Triggr::watch("MyEvent:AlertUser", function(){ echo "Watch out user!"; });

#####You can have multiple Handlers per event, options allow you to order them, or prevent them from being run multiple times per script execution, also, you aren't limited to lambda functions:
Triggr::watch("MyEvent", SomeClass::staticFunc, array("RunLimit"=>4, "Priority" => 1));

#####Default options values are RunLimit => 0 (this means infinite) and Priority => 100

#####You can pass arguments to you event as well.
Triggr::watch("SaveEvent", function($item){ $item->save(); });
$obj = new Something();
Triggr::fire("SaveEvent", array($obj));
