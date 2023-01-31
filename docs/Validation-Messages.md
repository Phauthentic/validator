## Translating Messages

### Why no translation feature?

Because it is a validator library. You can nonetheless translate the messages using your frameworks or favorite translation library. It is not the job of the validator to provide its own translation system, it is simply out of scope of validation.

Adding our own assumption about how the translation system should work for this library would require any user of the library to either maintain two separate systems or somehow hook his own up.
