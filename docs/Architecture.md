# Architecture of the Library

## Background

Why yet another validation library? There are indeed already quiet a few very good validation libraries out there and different libs cater different flavours. However, we were not able to find one for our taste.

`rakit/validation` is a pretty good one but no longer being maintained, `somnambulist/validation`, which is a fork of Rakit is almost perfect, but not as flexible and extendable as we would like it to be.  Finally, there is also `symfony/validator`, which is also really nice but we consider it to complicated, you have to write too much code to get the rules set up.

The goal of this library is to provide an easy to change and extend but also easy to use validator. You should have to write as few code as possible to get your data validated and the code you have to write should be expressive and convenient to use.

## Requirements

We had the following design goals regarding a validator library:

* **Must** be dependency free.
* **No** exception driven development. Exceptions are **forbidden** to be used to control business logic.
* Every element of the system **should** be replaceable and extendable.
* The validator **must** return a result object.
* **Must** follow the SOLID principles.
* Developer experience **may be** considered a higher priority than perfect abstraction.

### Rationale

None of the above requirements were fulfilled by any other library we looked at to the extent we were willing to accept it, therefore this library here was created.

## Ubiquitous Language

A description of the elements used within the context of the validator library.

* **Error** - An error for a rule failing to validate in the context of a field.
* **Result** - The result of the validation of a set of data.
* **Field** - Describes a field, key or index of the array data to be validated.
* **Rule Description** - A rule description is the **description** of a rule but **not** the implementation. It's basically just a name for a rule and a set of arguments that are then mapped to the actual implementation of a rule by that name.
* **Rule** is a **stateless** class that implements the actual check of a value.

## The Validator

The validator is basically the facade for everything else, it validates the fields based on their rule definitions.

The rule definitions are mapped to rules that then get executed and get the arguments and context of the validation passed to them.

After all fields were validated, a result object is returned.

## Rules

Rules are stateless. To make rules re-usable across many validators, they **must** be stateless.

The rule collection is thought to be shared via DI between multiple validators, to avoid that you have create instances of the rules for every validator.

A trade-off to getting strict type rules is that the rules interface **does not** provide the `validate()` method.

The convention is to pass the value that needs to be checked as first argument, followed by the arguments needed for this rule and optionally the context object as last argument.

## Fields & Rule Descriptions

TBD
