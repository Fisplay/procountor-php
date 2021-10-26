# Code architecture

This document describes how classes are arranged in the project and what are their responsibilities.

## Collections

Objects which represent arrays in the API description.

## Interfaces

API endpoint specific resource definitions.

Root level contains the definitions which are identical in both, read and write, use cases.

Subfolders, Read and Write, contain interfaces which extend the root resource definition, but with use case specific definitions.

These are the interfaces, which the project using this package, need to implement for sending data to the API.

## Json

This is about core functionality, non API related. Holds only one class, `Builder`, which purpose is to turn API related objects into a json strings.

## Resources

API resource definitions.

Defines which API resource it represents and which interface should be used with it for Read and Write use cases.

## Response

These classes realize read type Interfaces (described earlier in this document). These are initialized and returned from client requests.
