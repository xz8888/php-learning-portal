A basic template for a PHP portal site that calls [NetDimensions Talent Suite](http://www.netdimensions.com/talent-suite/)'s [API](http://www.netdimensions.com/solutions/learning-portals.php) using delegated authentication.

To configure delegated authentication you will need to rename the file named `config_sample.php` to `config.php` and then edit the values of the variables described below.

  * `$ekp_base` needs to point to the base URL of the NetDimensions Talent Suite site.
  * `$auth_key` should have the same value as the `authentication.key` property defined in `ekp.properties`.
  * Create a user in NetDimensions Talent Suite with the **Switch User** permission (probably a System Administrator) and configure `$admin_user_name` and `$admin_password` as, respectively, the user ID and password of that user. (This is the user that the PHP site will authenticate as when calling the API.)
  * `$auth_callback` should be the absolute URL of the file `auth_callback.php`.

You will also need to add the host name or IP address of the PHP site to the list **Trusted relying parties for delegated authentication**, which is under the **Users** category of **Manage** > **System Administration** > **System Settings** > **System Configuration**. (The value configured here must exactly match the host portion of the `$auth_callback` value configured above.)

If you want to use a custom login page template for the portal (that is, different from the generic login page template for the NetDimensions Talent Suite site), place the login page template under the `WEB-INF/conf/` directory and add the value **`host`**`:`**`template`** under **Trusted relying parties for delegated authentication**, where **`host`** is the host name or IP address of the PHP site and **`template`** is the file name of the custom login page template. Example: `www.example.com:myTemplate.wm`

Delegated authentication is explained in more detail in the [documentation](https://wiki.netdimensions.com/confluence/display/ptk/Delegated+authentication).