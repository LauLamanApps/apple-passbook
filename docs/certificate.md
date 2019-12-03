#Convert a CER file into a P12 file

Apple provides certificate files (CER files). To use these certificates with the Adobe PhoneGap Build service and the Push Notification plugin, you'll need to package them with their private keys in a Personal Information Exchange file (P12 file). Use the instructions below to package your CER file into a P12 file on a Mac.  

1. Open the **Keychain Access** application from the **Applications > Utilities** folder.
2. Import the certificate file (CER file) by selecting **File > Import** and locating your CER file provided by Apple.
3. Select the **Certificates** category and locate the certificate that you just imported.
4. Expand the arrow next to the certificate to show the key. 
5. Select the key.
6. Select **File > Export Items**...
7. Name the export and ensure that the file format is **Personal Information Exchange (.p12)**.
8. Click **Save**.
9. Provide a password to protect the export. This password will need to be provided to services that will use the certificate.
10. Click **OK**.
11. Provide your Mac password to enable the export.
12. Click **Allow**
13. The P12 file should now exist in the location you selected in step 7.
 