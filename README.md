## Sips Paypage POST PHP samples
The code samples in this repository help you to connect to Sips paypage POST (using PHP). This repository contains several use cases.

### Contents
 **1. Folder Common**

This folder contains all the files that are common to all use cases.
- sealCalculationPaypagePost.php : This file contains functions to calculate the seal with the 2 algorithms [HMAC-SHA-256](https://documentation.sips.worldline.com/en/WLSIPS.317-UG-Sips-Paypage-POST.html) and [SHA-256](https://documentation.sips.worldline.com/en/WLSIPS.317-UG-Sips-Paypage-POST.html)
- paymentResponse.php : This file displays the manual response to the payment request and calculates the seal to compare it with the seal received in the Sips response
- flatten.php : This file contains the different functions used to return the string that can be submitted to Sips server to initiate a payment on Paypage POST interface
- redirectionForm.php : This is the form to redirect to Paypage Post interface

 **2. Other files**

Each file corresponds to a payment type and contains the code that generates the payment request and sends it to Sips server.

### Running the test
- Clone the repository and keep the folder structure as it is in GitHub
- Change the value of the normalReturnUrl field according to your architecture
- Check the uniqueness of the value in the transactionReference field when it is filled out 
- In the case of payment by installments, change due dates and the transaction reference list if necessary
- Execute the payment request file on a local web server for the use case you want to test

### Version
These examples has been validated on a WAMP server with PHP version 7.3.12 .

### Documentation
The code examples are based on our developer documentation, which provides comprehensive information on how Sips Paypage JSON works. For more information, refer to the [Sips Paypage POST documentation](https://documentation.sips.worldline.com/en/WLSIPS.317-UG-Sips-Paypage-POST.html).

### License
This repository is open source and available under the MIT license. For more information, see the [LICENSE](LICENSE) file.
