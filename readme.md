# BizPress

BizPress is Bizink's collection of WordPress plugins.

## BizPress Pliguns
- BizPress Main - This repo
- BizPress - Accounting Glossary [https://github.com/BizInk/bizpress-accounting-glossary](https://github.com/BizInk/bizpress-accounting-glossary)
- BizPress - Business Terms Glossary [https://github.com/BizInk/bizpress-business-terms-glossary](https://github.com/BizInk/bizpress-business-terms-glossary)
- BizPress - Key Dates [https://github.com/BizInk/bizpress-key-dates](https://github.com/BizInk/bizpress-key-dates)
- BizPress - Xero Resources [https://github.com/BizInk/bizpress-xero-resources](https://github.com/BizInk/bizpress-xero-resources)
- BizPress - Quickbooks Resources [https://github.com/BizInk/bizpress-quickbooks-resources](https://github.com/BizInk/bizpress-quickbooks-resources)
- BizPress - Business Resources [https://github.com/BizInk/bizpress-business-resources](https://github.com/BizInk/bizpress-business-resources)
- BizPress - Luca [https://github.com/BizInk/bizpress-luca](https://github.com/BizInk/bizpress-luca)
- Bizpress - WC [https://github.com/BizInk/bizink-wc](https://github.com/BizInk/bizink-wc) - Validates User logins this is on the Bizink site

## How to update the plugin
1. Have the latest version of the plugin in the master/main branch
    - Note this should contain the latest version number in the plugin file ```bizink-clinet.php```
2. Make sure the **Readme.txt** file is up to date - This file is written in **WordPress Markdown** see Readme.txt section below
    - This has a Version item and a Stable Tag item **both** should be the new verson number e.g. 1.0
    - This file also has a Change Log included. Update this as this file is used by wordpress to show changes on the plugin update section
3. Create a new Release in the releases tab. **Important:** Make sure the tag is the new version number e.g. 1.0
    - If the release is marked as *Pre Release* the plugin updater will ignore it.
    - We should also put what has changed in the release notes but these would be for our benefit and not used by the plugin.

### Readme.txt
This file is written in **WordPress Markdown** this is different to GitHub Markdown and is also different to the Readme.md file. It is required for the updater to work. Update the details in this file on the master branch then add a new release with the github tag in order to post a new version of the plugin. [Follow this example https://wordpress.org/plugins/readme.txt](https://wordpress.org/plugins/readme.txt)

### Tags
Using the master branch create a tag with the name being the version number of the release. **Note:** It should be the same version number in the plugin files and the readme.txt file