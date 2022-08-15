# Wi-Fi management interface for UniFi networks

![](https://i.imgur.com/E5qDzk8.png)

This software has been created especially for the needs of the Freie Waldorfschule Augsburg.
User authentication is achieved through LDAP using the school's own local Active Directory.
In this way, no additional user accounts need to be set up to use the system.

To communicate with the UniFi network infrastructure, we use
the [UniFi-API-client from Art-of-WiFi](https://github.com/Art-of-WiFi/UniFi-API-client).
With this library the system provides mainly two functions.

### Features

- *Authentication via Active Directory using LDAP*
- Create and delete RADIUS accounts
    - *Used for the student hotspot*
- Create and delete vouchers
    - *Used for Wi-Fi usage in class*
    - *Used for general purpose guest Wi-Fi access (e.g. at school events)*

### ToDo

- Restrict non-admins to have only **one** active voucher at a time (not sure if necessary)