# rest-api
This is a simple REST API Authentication that performs CRUD operations in PHP - JWT.

As we know, JWT-JSON Web Token is an internet standard that defines a compact way of securely transmitting information between parties
as JSON object.
The information that is being transmitted can be trusted because it is digitally signed using a secret key with HMAC algorithm. Example,
a server could generate a token with a claim "User Logged In" to a client, the client will then uses that token to verify it is logged in
as an accepted user.

The JWT in its serialized form looks like: header.payload.signature
The header component contains information about how JWT signature should be computed. The payload component is the data that is 
stored inside the JWT. This can be user information like user ID, name and email.

To create the signature component, you have to take the encoded header, the encoded payload, a secret, the algorithm specified in 
the header, and sign that

At the initial stage, several APIs were created to illustrate these processes.
* create_user API: this performs the Creation of users
* login: this performs the Read operation
* update_user: this performs the updating of users' details
* delete_user: this performs the deletion of user
* verify_token: this is to check if our generated JWT is valid

All of the above were verified using an HTTP client to test our services.
